<?php
declare (strict_types = 1);

namespace app\listener;
use think\facade\Queue;

class SmsTask
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle($event)
    {
        var_dump($event->data);//event的data数据即server->task()传入的数据

        /*创建新消息并推送到消息队列*/
        // 当前任务由哪个类负责处理
        $job_handler_classname = "app\job\Dismiss";
        // 当前队列归属的队列名称
        $job_queue_name = "dismiss_job_queue";
        // 当前任务所需的业务数据
        $job_data = ["ts"=>time(), "bizid"=>uniqid(), "params"=>$event->data];
        // 将任务推送到消息队列等待对应的消费者去执行
        $is_pushed = Queue::push($job_handler_classname, $job_data, $job_queue_name);
        // 可以调用 finish 方法通知其他事件类，通知当前异步任务已经完成了(非必须调用)
        // 参数 $event 是 Swoole\Server\Task 类的一个对象 可以调用 finish 方法触发 task 任务的 onFinish 事件
        $event->finish($event->data);
        return;
    }
}
