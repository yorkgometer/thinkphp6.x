<?php

use think\swoole\websocket\socketio\Handler;

return [
    'server'     => [
        'host'      => env('SWOOLE_HOST', '0.0.0.0'), // 监听地址
        'port'      => env('SWOOLE_PORT', 9501), // 监听端口
        'mode'      => SWOOLE_PROCESS, // 运行模式 默认为SWOOLE_PROCESS
        'sock_type' => SWOOLE_SOCK_TCP, // sock type 默认为SWOOLE_SOCK_TCP
        'options'   => [
            'pid_file'              => runtime_path() . 'swoole.pid',
            'log_file'              => runtime_path() . 'swoole.log',
            'daemonize'             => false,
            // 通常，根据您的 cpu 核心，该值应大 1~4 倍
            /*
            //设置主进程线程数
            Reactor线程数，通过此参数来调节主进程内事件处理线程的数量，以充分利用多核。默认会启用CPU核数相同的数量

            .reactor_num建议设置为CPU核数的1-4倍
            .reactor_num最大不得超过SWOOLE_CPU_NUM * 4

           Reactor线程是可以利用多核，如：机器有128核，那么底层会启动128线程。每个线程能都会维持一个EventLoop。线程之间是无锁的，指令可以被128核CPU并行执行。考虑到操作系统调度存在一定程度的性能损失，可以设置为CPU核数*2，以便最大化利用CPU的每一个核

           reactor_num必须小于或等于worker_num,如果设置的reactor_num大于worker_num，会自动调整使reactor_num等于worker_num
            */
            'reactor_num'           => 2,//swoole_cpu_num(),
            /*
            设置Worker进程数

            .业务代码是全异步非阻塞的，这里设置为CPU核数的1-4倍最合理
            .业务代码为同步阻塞，需要根据请求响应时间和系统负载来调整，例如：100-500
            .默认设置为SWOOLE_CPU_NUM，最大不得超过SWOOLE_CPU_NUM * 1000

           如1个请求耗时100ms，要提供1000QPS的处理能力，那必须配置100个进程或更多。但开的进程越多，占用的内存就会大大增加，而且进程间切换的开销就会越来越大。所以这里适当即可。不要配置过大
           .假设每个进程占用40M内存，100个进程就需要占用4G内存
            */
            'worker_num'            => 8,//swoole_cpu_num(),
            'task_worker_num'       => 8,//swoole_cpu_num(),
            'enable_static_handler' => true,
            'document_root'         => root_path('public'),
            'package_max_length'    => 20 * 1024 * 1024,
            'buffer_output_size'    => 10 * 1024 * 1024,
            'socket_buffer_size'    => 128 * 1024 * 1024,
        ],
    ],
    'websocket'  => [
        'enable'        => true,//开启WebSocket 服务，将false设置为true
        'handler'       => Handler::class,
        'ping_interval' => 25000,
        'ping_timeout'  => 60000,
        'room'          => [
            'type'  => 'table',
            'table' => [
                'room_rows'   => 4096,
                'room_size'   => 2048,
                'client_rows' => 8192,
                'client_size' => 2048,
            ],
            'redis' => [
                'host'          => '127.0.0.1',
                'port'          => 6379,
                'max_active'    => 3,
                'max_wait_time' => 5,
            ],
        ],
        //WebSocket的事件也可以在"websocket.listen"进行配置
        'listen'        => [
            /*
            // 首字母大小写都可以；值应该是字符串非数组
            'connect' => 'app\listener\WsConnect',
            'close'   => 'app\listener\WsClose',
            'test'    => 'app\listener\WsTest'
            */
        ],
        'subscribe'     => [],
    ],
    'rpc'        => [
        'server' => [
            'enable'   => true,
            'port'     => 9000,
            'services' => [
                \app\rpc\service\UserService::class
            ],
        ],
        'client' => [
        ],
    ],
    /*
       热更新：
       //由于Swoole服务运行过程中 PHP 文件是常驻内存运行的，这样可以避免重复读取磁盘、重复解释编译 PHP，以便达到最高性能。所以更改业务代码后必须手动 reload或者restart才能生效
       //think-swoole 扩展提供了热更新功能，在检测到相关目录的文件有更新后会自动 reload，从而不需要手动进行 reload 操作，方便开发调试
       //如果你的应用开启了调试模式，默认是开启热更新的。原则上，在部署模式下不建议开启文件监控，一方面有性能损耗，另外一方面对文件所做的任何修改都需要确认无误才能进行更新部署
       */
    'hot_update' => [
        'enable'  => true,//env('APP_DEBUG', false),//env('APP_DEBUG', false),//是否开启热更新
        'name'    => ['*.php'],//监控哪些类型的文件变动
        'include' => [app_path()],//监控哪些路径下的文件变动
        'exclude' => [],//排除目录
    ],
    //连接池
    'pool'       => [
        'db'    => [
            /*
             什么enable设置为true，就启动了连接池呢？
            因为在InteractsWithServer->onWorkerStart()事件中开启了协程，调用了prepareApplication，对db、cache进行重新绑定，替换为连接池实例，请参考thinkphp6.x\vendor\topthink\think-swoole\src\concerns\WithApplication.php中function prepareApplication(string $envName){......}方法
             */
            'enable'        => true,// 是否启用，不启动设置为false
            'max_active'    => 3,// 最大连接数，超过将不再新建
            'max_wait_time' => 5,// 超时时间
        ],
        'cache' => [
            'enable'        => true,// 是否启用，不启动设置为false
            'max_active'    => 3,// 最大连接数，超过将不再新建
            'max_wait_time' => 5,// 超时时间
        ],
        //自定义连接池
    ],
    //队列
    'queue'      => [
        'enable'  => false,
        'workers' => [],
    ],
    'coroutine'  => [
        'enable' => true,
        'flags'  => SWOOLE_HOOK_ALL,
    ],
    'tables'     => [
        //定义商品表
        'goods'   => [
            //表格占用的共享内存大小
            'size' => 1024,
            //定义表列，可以理解为数据库的字段
            'columns' => [
                [
                    //字段名
                    'name' => 'id',
                    //字段类型，只支持三种
                    //TYPE_INT，size默认占 4 个字节，可以设置 1，2，4，8 一共 4 种长度
                    //TYPE_STRING，size必须设置，设置的字符串不能超过此长度
                    //TYPE_FLOAT，会占用 8 个字节的内存
                    'type' => \SWOOLE\Table::TYPE_INT
                ],
                [
                    'name' => 'sku',
                    'type' => \SWOOLE\Table::TYPE_STRING
                    ,
                    //设置占用字节
                    'size' => 32
                ],
                [
                    'name' => 'kucun',
                    'type' => \SWOOLE\Table::TYPE_INT
                ]
            ]
        ]
    ],
    //每个worker里需要预加载以共用的实例
    'concretes'  => [],
    //重置器
    'resetters'  => [],
    //每次请求前需要清空的实例
    'instances'  => [],
    //每次请求前需要重新执行的服务
    'services'   => [],
];
