<?php

class Abc
{
    public function index($request){
        //返回请求结果
        return "<h1>Hello Swoole. #".rand(1000, 9999)."</h1>";
    }
}