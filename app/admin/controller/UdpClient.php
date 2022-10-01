<?php

namespace app\admin\controller;

use app\BaseController;

class UdpClient extends BaseController
{

    public function demo()
    {
        // 创建UDP客户端
        $client = new \Swoole\Client(SWOOLE_SOCK_UDP, SWOOLE_SOCK_SYNC);
        // 发送消息
        $client->sendto('192.168.63.113', 9602, "I am client..." . PHP_EOL);
        // 打印服务端返回的消息
        echo $client->recv() . PHP_EOL;
        exit();
    }
}