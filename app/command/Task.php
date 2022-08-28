<?php
declare (strict_types=1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class Task extends Command
{
    //配置任务信息
    protected function configure()
    {
        // 指令配置
        $this->setName('task')
            ->setDescription('计划任务 Task');
    }

    //调用Task这个类时,会自动运行execute方法
    protected function execute(Input $input, Output $output)
    {
        // 指令输出
        $output->writeln('Date Crontab job start...');
        /*** 这里写计划任务列表集 START ***/
        $this->sendMessage();//发短信
        /*** 这里写计划任务列表集 END ***/
        // 指令输出
        $output->writeln('Date Crontab job end...');
    }

    //发短信逻辑代码
    public function sendMessage()
    {
        echo '这里写你要实现的逻辑代码'.PHP_EOL;
    }
}
