<?php
// 应用公共文件

function show($status = 0, $msg = "", $datas = [], $httpStatus = 200)
{
    //如果消息提示为空，并且业务状态码定义了，那么就显示默认定义的消息提示
    if (empty($msg) && !empty(config("status." . $status))) {
        $msg = config("status." . $status);
    }

    $result = [
        'status' => $status,
        'msg' => $msg,
        'datas' => $datas
    ];

    if (request()->isAjax()) {
        return json($result, $httpStatus);
    }

    return $msg;
}

/**
 * 生成令牌
 */
function shopToken()
{
    $data = request()->buildToken('__token__', 'sha1');
    return '<input type="hidden" name="__token__" value="' . $data . '" class="token">';
}

//生成并导出证书
function exportSSLFile(){
    $config = array(
        "digest_alg"        => "sha512",
        "private_key_bits"     => 4096,           //字节数  512 1024 2048  4096 等
        "private_key_type"     => OPENSSL_KEYTYPE_RSA,   //加密类型
    );
    $res = openssl_pkey_new($config);
    if ( $res == false ) return false;
    openssl_pkey_export($res, $private_key);
    $public_key = openssl_pkey_get_details($res);
    $public_key = $public_key["key"];
    file_put_contents(app()->getRootPath() . "public/cert_public.key", $public_key);
    file_put_contents(app()->getRootPath() . "public/cert_private.pem", $private_key);
    openssl_free_key($res);

}

//公钥加密，私钥解密
function authCode($string, $operation = 'E') {
    $ssl_public     = file_get_contents(app()->getRootPath() . "public/cert_public.key");
    $ssl_private    = file_get_contents(app()->getRootPath() . "public/cert_private.pem");
    $pi_key         = openssl_pkey_get_private($ssl_private);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
    $pu_key         = openssl_pkey_get_public($ssl_public);//这个函数可用来判断公钥是否是可用的
    if( false == ($pi_key || $pu_key) ) return '证书错误';

    $data = "";
    if( $operation == 'D') {
        openssl_private_decrypt(base64_decode($string),$data,$pi_key);//私钥解密
    } else {
        openssl_public_encrypt($string, $data, $pu_key);//公钥加密
        $data = base64_encode($data);
    }

    return $data;
}

//私钥签名
function sign($string) {
    $ssl_private    = file_get_contents(app()->getRootPath() . "public/cert_private.pem");
    $pi_key         = openssl_pkey_get_private($ssl_private);

    if( false == ($pi_key) ) return '证书错误';

    openssl_sign($string,$signature,$pi_key);//生成签名
    $data = base64_encode($signature);
    openssl_free_key($pi_key);
    return $data;
}

//公钥验签
function verifySign($string, $signData) {
    $ssl_public     = file_get_contents(app()->getRootPath() . "public/cert_public.key");
    $pu_key         = openssl_pkey_get_public($ssl_public);

    if( false == ($pu_key) ) return '证书错误';

    $verify = openssl_verify($string, base64_decode($signData), $pu_key);
    openssl_free_key($pu_key);
    return $verify;
}