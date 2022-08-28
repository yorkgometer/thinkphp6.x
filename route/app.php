<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

//当路由规则都不匹配的话，会路由到`miss`
Route::miss(function () {
    return show(10000);
});

Route::get('index', 'index/index');
Route::post('submit', 'index/submit');

Route::get('say', 'index/say');
//或
//Route::get('say', "app\controller\Index::say");

Route::get('oauth/jwt/createJwt', "app\controller\oauth\jwt::createJwt");
Route::post('oauth/jwt/verifyJwt', "app\controller\oauth\jwt::verifyJwt");


Route::get('exportSSLFile', 'index/exportSSLFile');
Route::post('testRSA', 'index/testRSA');


















