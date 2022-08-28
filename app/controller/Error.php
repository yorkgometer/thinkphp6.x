<?php

namespace app\controller;

class Error
{
    public function __call($name, $arguments)
    {
        //模块不存在，会运行
        return show(10001);
    }
}