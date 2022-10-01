<?php
declare (strict_types = 1);

namespace app\listener;
use \think\swoole\Websocket;

class WsConnect
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle($event,Websocket $ws)
    {
        //$ws = app('\think\swoole\Websocket');//单例方式实例化Websocket，如果这样写，那么获取不到fd，因此注释掉了
        //获取当前发送消息客户端的fd(fd是在Swoole中客户端的唯一标识符，fd是复用的，当连接关闭后fd会被新进入的连接复用，正在维持的TCP连接fd不会被复用)
        var_dump('WsConnect fd：'.$ws -> getSender());
        //print_r($event);
        $ws->emit('fd','当前客户端fd：'.$ws->getSender());
    }
}