<?php
declare (strict_types = 1);

namespace app\listener;

class OrderCancelTask
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle($event)
    {
        var_dump($event->data);

        //echo iconv('utf-8', 'gbk//IGNORE','下单成功时间：').time().PHP_EOL;
        echo '下单成功时间'.time().PHP_EOL;

        //模拟1分钟后取消订单
        //`Swoole\Timer::after`在指定的时间后执行函数，是一个一次性定时器，执行完成后就会销毁。
        //function (int $timer_id, $param)2个参数会报错，参数多了，去掉int $timer_id,参数
        \Swoole\Timer::after(60000, function ($param) {

            //TODO 判断订单是否已经支付，如果未支付，取消订单

            //echo iconv('utf-8', 'gbk//IGNORE','订单编号：') .$param["orderSn"].iconv('utf-8', 'gbk//IGNORE','超时未支付，已取消').PHP_EOL;
            echo '订单编号：'.$param["orderSn"].'超时未支付，已取消'.PHP_EOL;
            echo time().PHP_EOL;

        }, $event->data);


        return;
    }
}
