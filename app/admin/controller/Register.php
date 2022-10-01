<?php

namespace app\admin\controller;

use app\BaseController;

/**
 * 用户注册
 * Class Register
 * @package app\admin\controller
 */
class Register extends BaseController
{
    public function register()
    {

        //TODO 调用验证类验证数据
        //TODO 将注册信息插入数据库

        //异步模拟发送短信
        $manager = app('\think\swoole\Manager');
        $data = [
            'task' => 'sendSms',
            'mobile' => '15210797868',
        ];
        //传递参数
        $manager->getServer()->task($data);
        return "注册成功！".time();
    }
}