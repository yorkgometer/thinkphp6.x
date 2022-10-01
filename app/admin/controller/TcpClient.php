<?php

namespace app\admin\controller;

use app\BaseController;

class TcpClient extends BaseController
{
    public function demo()
    {
        // 创建TCP客户端
        $client = new \Swoole\Client(SWOOLE_SOCK_TCP);

        /**
         * 函数：bool Client->connect(string $host, int $port, float $timeout = 0.5)
         * 作用：连接到服务器
         * 参数：
         *  $host，远程服务器的地址
         *  $port，远程服务器端口
         *  $timeout，网络 IO 的超时时间
         */
        if (!$client->connect('192.168.63.113', 9601, 0.5)) {
            die("连接失败").PHP_EOL;
        }

        //向服务器发送数据
        if (!$client->send("hello world")) {
            echo '发送失败'.PHP_EOL;
        }

        //从服务器接收数据
        $data = $client->recv();
        if (!$data) {
            die("接收失败").PHP_EOL;
        }

        //打印从服务端接收到的数据
        echo $data;

        //关闭连接
        $client->close();
        exit();
    }
}