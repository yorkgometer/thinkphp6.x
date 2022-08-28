<?php

use think\facade\Route;

//自定义admin应用路由访问地址
//真实路由地址(应用名/控制器/方法)，应用名可忽略，因为你在该应用下的路由中定义路由(即thinkphp6.x\app\admin\创建route\route.php)
//Route::any('index','admin/index/index');

//Route::any('index', 'index/index');

//路由分组
Route::group('admin',function (){
    Route::any('index', 'index/index');
});