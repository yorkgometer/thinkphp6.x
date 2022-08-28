<?php
declare (strict_types=1);

namespace app\command;

use app\home\model\Order;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class shopSpike extends Command
{
    //配置任务信息
    protected function configure()
    {
        // 指令配置
        $this->setName('task')
            ->setDescription('商品秒杀消费队列计划任务');
    }

    //调用Task这个类时,会自动运行execute方法
    protected function execute(Input $input, Output $output)
    {
        // 指令输出
        $output->writeln('Date Crontab job start...');
        /*** 这里写计划任务列表集 START ***/
        $this->shopSpike();//消费商品秒杀队列
        /*** 这里写计划任务列表集 END ***/
        // 指令输出
        $output->writeln('Date Crontab job end...');
    }


    //消费商品秒杀队列
    public function shopSpike()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        do {
            $orders = $redis->rPop('orders');
            $orders = !empty($orders) ? unserialize($orders) : [];
            if (!empty($orders)) {
                // 写入数据库
                Order::create(['user_id' => $orders['user_id'], 'good_id' => $orders['good_id']]);
            }
        } while (!empty($orders));

        echo '消费商品秒杀队列消费完成 '.date('Y-m-d H:i:s').PHP_EOL;
        /*
        while (true) {
            $orders = $redis->rPop('orders');
            $orders = !empty($orders) ? unserialize($orders) : [];
            if (!empty($orders)) {
                // 写入数据库
                Order::create(['user_id' => $orders['user_id'], 'good_id' => $orders['good_id']]);
            }

            if ($redis->lLen('orders') == 0) {
                usleep(500000); //暂停500毫秒
            }
        }
        */
    }

}
