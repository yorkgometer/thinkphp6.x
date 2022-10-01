<?php
// 事件定义文件
return [
    'bind'      => [
    ],

    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
        //其中swoole.task这个键名是 Task 任务固定写法不能随意命名
        'swoole.task'=>[
            //app\listener\SmsTask::class,
            //app\listener\OrderCancelTask::class,
        ],
        /*
        监听连接：swoole事件必须以swoole开头
        客户端与服务器建立连接并完成握手事件，即 Swoole 中的 onOpen 事件。
        在这里记录你自己程序用户与客户端的连接ID(fd)等。非必须建议定义
        */
        'swoole.websocket.Connect' => [
            app\listener\WsConnect::class
        ],
        //监听关闭：客户端连接关闭事件，非必须
        'swoole.websocket.Close' => [
            app\listener\WsClose::class
        ],

        //监听Test场景：自定义的 Test 事件；用于接收客户端发送的test事件的消息。一个项目中可以定义多个Test事件，例如：聊天、定位、客服功能事件，则可对应为 Test1、Test2、Test3等
        'swoole.websocket.Test' => [
            app\listener\WsTest::class
        ],

        //其中swoole.finish这个键名是 Task 通知当前异步任务已经完成固定写法不能随意命名
        'swoole.finish' => [
            //app\listener\SmsTaskFinish::class,
        ],
    ],

    'subscribe' => [
    ],
];