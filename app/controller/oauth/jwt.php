<?php

namespace app\controller\oauth;

use app\BaseController;
use Firebase\JWT\Key;
use think\Request;

class Jwt extends BaseController
{
    //生成token
    public function createJwt()
    {
        $data = ['age' => 98];
        $key = md5('zq8876!@!'); //jwt的签发密钥，验证token的时候需要用到
        $time = time(); //签发时间
        $expire = $time + 14400; //过期时间
        $token = array(
            "user_id" => 'zq',
            "iss" => "http://www.thinkphp6.x.com/",//签发组织、人(官方字段:非必需)
            "aud" => "york", //签发作者、受众(官方字段:非必需)
            "iat" => $time,//签发时间
            "nbf" => $time, //生效时间，立即生效
            "exp" => $expire,//过期时间，一周
            'data' => $data, //自定义字段
        );
        //新版JWT新增的
        $keyId = "keyId";//这个东西可能要加上，不加上，报错，报错内容：'"kid" empty, unable to lookup correct key'
        //旧版jwt写法
        //$jwt = JWTUtil::encode($token, $key);
        //最新版Firebase\JWT\JWT包jwt写法
        $jwt = \Firebase\JWT\JWT::encode($token, $key, 'HS256', $keyId);
        return $jwt;
    }

    //校验jwt权限API
    public function verifyJwt(Request $request)
    {
        $authorization = $request->header("authorization");
        // 获取token
        {
            // 异常捕获无效
            try {
                //$token = substr($authorization,8,-1);
                $jwt = substr($authorization, 7);
            } catch (\Exception $ex) {
                $jwt = $authorization;
            }
        }
        //旧版jwt写法
        //$key = md5('zq8876!@!');
        // ==========================主要是下面这一段=====
        //最新版Firebase\JWT\JWT包jwt写法
        $key = new Key(md5('zq8876!@!'), 'HS256');
        // 如果当前时间大于 exp，或者小于nbf，token无效，进行拦截
        \Firebase\JWT\JWT::$leeway = 60;//当前时间减去60，把时间留点余地
        // ==========================主要是上面面这一段=====
        try {
            //旧版jwt写法
            //$jwtAuth = json_encode(JWTUtil::decode($jwt, $key, array('HS256')));
            $jwtAuth = json_encode(\Firebase\JWT\JWT::decode($jwt, $key));
            //最新版Firebase\JWT\JWT包jwt写法
            $authInfo = json_decode($jwtAuth, true);
            $msg = [];
            if (!empty($authInfo['user_id'])) {
                $msg = [
                    'status' => 1001,
                    'msg' => 'Token验证通过'
                ];
                // 比较当前时间大于 exp，或者小于nbf，token无效，进行拦截
                if ($authInfo['nbf'] > time()) {
                    $msg = [
                        'status' => 1002,
                        'msg' => '权限伪造！'
                    ];
                } elseif ($authInfo['exp'] < time()) {
                    $msg = [
                        'status' => 1003,
                        'msg' => '权限过期，请重新登录！！'
                    ];
                }
            } else {
                $msg = [
                    'status' => 1004,
                    'msg' => 'Token验证不通过,用户不存在'
                ];
            }
            echo json_encode($msg);
            exit();
        } catch (\Firebase\JWT\ExpiredException $e) {
            echo json_encode([
                'status' => 1003,
                'msg' => 'Token过期'
            ]);
            exit;
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 1002,
                'msg' => 'Token无效'
            ]);
            exit;
        }
    }


}