<?php
declare (strict_types = 1);

namespace app\listener;
use \think\swoole\Websocket;

class WsTest
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle($event,Websocket $ws)
    {
        //$ws = app('think\swoole\Websocket');//单例方式实例化，如果这样写，那么获取不到fd，因此注释掉了
        //获取当前发送消息客户端的fd(fd是在Swoole中客户端的唯一标识符，fd是复用的，当连接关闭后fd会被新进入的连接复用，正在维持的TCP连接fd不会被复用)
        var_dump('WsTest fd：'.$ws->getSender());
        print_r($event);
        /*
         //发送给指定 fd 的客户端，包括发送者自己
         $ws->to()：设置收件人 fd 或聊天室名，如果发送给多个人可以数组设置多个，例如 [1,2,3]，fd 须为整型
         $ws->emit()：发送消息方法，第一个参数是事件名称，用于多场景，可任意定义。第二个参数是发送的内容，可以是字符串、数组，单独调用不设置收件人的话，就是发送消息给当前fd
        */
        $ws->to(intval($event['to']))->emit('content',['收到来自客户端【'.$ws->getSender().'】发消息：'.$event['message']]);

        /*
        //发送广播消息，群发消息
        $ws->broadcast()->emit('content',['收到来自客户端【'.$ws->getSender().'】发消息：'.$event['message']]);
        //如果想自己也收到广播消息，那就需要增加下面一行代码即可
        $ws->to($ws->getSender())->emit('content',['收到来自【自己】发消息：'.$event['message']]);
        */

        /*
        //模拟某客户端给另一个客户端发消息
        //假设我当前fd为3，模拟用fd为4的客户端给fd为5的客户端发送消息，只需设置发送者fd和接收者两个fd即可,如下
        $ws->setSender(4)->to(5)->emit('content',['收到来自【自己】发消息：'.$event['message']]);
        */

    }
}