<?php

namespace app\rpc\service;

use app\rpc\interfaces\UserInterface;

class UserService implements UserInterface
{
    public function add($name)
    {
        return "您要新增的用户名是：{$name}";
    }
}