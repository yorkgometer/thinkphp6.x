<?php

namespace app\admin\controller;

use app\BaseController;
use think\Request;

class Test extends BaseController
{
    public function index(Request $request){
        //返回请求结果
        return "<h1>Hello Swoole. #".rand(1000, 9999)."</h1>";
    }
}