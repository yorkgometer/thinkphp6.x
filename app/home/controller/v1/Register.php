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
    public function register(\Swoole\Server $server)
    {
        return '123';
        $server -> task(\app\listener\EmailTask::class);
    }
}