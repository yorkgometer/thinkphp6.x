<?php

namespace app\home\controller\v1;

use app\home\controller\Common;
use think\App;

class OAuth extends Common
{
    protected $server;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $dsn = 'mysql:dbname=thinkphp6;host=192.168.63.113';
        $username = 'root';
        $password = '123456';
        \OAuth2\Autoloader::register();
        //创建存储的方式
        $storage = new \OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
        //创建server
        $server = new \OAuth2\Server($storage);
        // 添加password授予类型
        $server->addGrantType(new \OAuth2\GrantType\UserCredentials($storage));
        //添加refresh_token授予类型
        $server->addGrantType(new \OAuth2\GrantType\RefreshToken($storage, array(
            'always_issue_new_refresh_token' => true
        )));
        $this->server = $server;
    }

    //获取access_token和刷新token
    public function authorize()
    {
        $request = \OAuth2\Request::createFromGlobals();
        //如果grant_type=password，生成并获取token
        //如果grant_type=refresh_token，更新并获取token
        $res = $this->server->handleTokenRequest($request)->send();
    }

    //获取用户信息
    public function check()
    {
        if (!$this->server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())) {
            $this->server->getResponse()->send();
            die;
        }
        //获取用户信息
        $token = $this->server->getAccessTokenData(\OAuth2\Request::createFromGlobals());
        echo "User ID associated with this token is {$token['user_id']}";
    }

}