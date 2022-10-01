<?php

namespace app\home\controller\v1;

use app\BaseController;

/**
 * 订单管理
 * Class Order
 * @package app\controller
 */
class Order extends BaseController
{
    public function save()
    {
        //TODO 调用验证类验证数据
        //TODO 将订单信息插入数据库

        //异步模拟
        $manager = app('\think\swoole\Manager');
        $data = [
            'orderSn' => '202210011000',
            'time' => time()
        ];

        $manager->getServer()->task($data);
        return "下单成功！".time();
    }
}