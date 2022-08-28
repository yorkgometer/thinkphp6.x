<?php
use think\facade\Route;

//URL路由传入方式(api多版本路由)
Route::any(':version/:controller/:function', ':version.:controller/:function')
    ->allowCrossDomain([
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET,POST,OPTIONS',
        'Access-Control-Allow-Headers' => 'x-requested-with,content-type,token'
    ]);

/*
// 请求头传入方式(api多版本路由)
$version = request()->header('version');
//默认跳转到v1版本
if($version==null) $version = "v1";
Route::rule(':controller/:function', $version.'.:controller/:function');
*/