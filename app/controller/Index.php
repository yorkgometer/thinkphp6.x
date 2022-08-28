<?php

namespace app\controller;

use app\BaseController;
use think\exception\ValidateException;
use think\facade\View;
use think\Request;

class Index extends BaseController
{
    public function index()
    {
        return View::fetch('index');
    }

    public function submit(Request $request){
        $check = $this->request->checkToken('__token__', $this->request->param());

        if (false === $check) {
            throw new ValidateException('invalid token');
        }
        //......
        return 'token验证通过';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }

    public function say(Request $request)
    {
        return $request['username'];
    }

    //生成并导出证书
    public function exportSSLFile()
    {
        exportSSLFile();
        return '生成并导出证书成功';
    }


    //公钥私钥加解密
    public function testRSA()
    {
        $str = authCode('北京欢迎您，2022', 'E'); //加密
        echo '加密结果：' . $str . "<br>";
        echo '解密结果：' . authCode($str, 'D');//解密
    }


}
