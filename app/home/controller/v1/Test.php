<?php

namespace app\home\controller\v1;

use app\BaseController;

use think\facade\Cache;
use think\facade\Db;
use Yorkpack\Tool\Code;

/**
 * 测试类
 */
class Test extends BaseController
{


    public function limit($uid = 0)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);

        //单个用户每分钟访问数为10次
        $initNum = 10;//如果一瞬间访问10次，那么提示：当前时刻令牌消耗完，
        $expire = 60;//因为设置60秒访问10次，差不多平均隔10秒又可以访问通过

        $key = $uid . '_minNum';
        $redis->watch($key);
        $limitVal = $redis->get($key);
        if ($limitVal) {
            $limitVal = json_decode($limitVal, true);
            $nowtime = time();
            //计算当前时刻与上次访问的时间差乘以速率就是此次可以补充的令牌个数
            $newNum = min($initNum, ($limitVal['num'] - 1) + (($initNum / $expire) * ($nowtime - $limitVal['time'])));
            if ($newNum > 0) {
                $redisVal = json_encode(['num' => $newNum, 'time' => time()]);
            } else {
                exit(json_encode(['status' => false, 'msg' => '当前时刻令牌消耗完！']));
            }
        } else {
            //第一次访问时初始化令牌个数
            $redisVal = json_encode(['num' => $initNum, 'time' => time()]);
        }

        $redis->multi();
        $redis->set($key, $redisVal);
        $result = $redis->exec();

        if (!$result) {
            exit(json_encode(['status' => false, 'msg' => '访问频次过多！']));
        }

        //其他操作......

        return '访问成功';
    }


    public function lpush()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);

        //模拟100用户抢购某个商品,写队列里面
        for ($i = 1; $i <= 100; $i++) {
            $user_id = rand(100000, 999999);
            $orders = serialize(['user_id' => $user_id, 'good_id' => 1]);
            $redis->lPush('orders', $orders);
        }

        return '模拟抢购成功成功';
    }


    public function getUserData($user_id)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);

        // 缓存存在直接返回缓存
        if ($redis->exists("user:{$user_id}")) {
            echo '缓存存在直接返回缓存数据' . PHP_EOL;
            return $redis->get("user:{$user_id}");
        }

        //防止当持有锁的进程崩溃或删除锁失败时，其他进程将无法获取到锁（(setnx当key存在，不会覆盖key值，直接设置失败返回false，如果key不存在，会设置成功返回true)）
        $is_lock = $redis->setnx('lock', time() + 5);
        if (!$is_lock) {
            $lock_time = $redis->get('lock');
            //锁已过期，重置
            if ($lock_time < time()) {
                $this->unlock('lock');
                $is_lock = $redis->setnx('lock', time() + 5);
            }
        }

        // 如果某进程抢占成功，读取数据库，设置缓存
        if ($is_lock) {
            echo '某个进程抢到了锁，这个进程读取数据库，设置缓存' . PHP_EOL;
            $data = json_encode(Db::name('user')->where('id', $user_id)->find());
            // 缓存数据
            $redis->set("user:{$user_id}", $data);
            // 释放锁
            $redis->del('lock');
        } else {
            echo '其他线程没有获得锁，继续等待锁释放...' . PHP_EOL;
            do {
                //如果某线程抢占失败再挂起50ms,直到缓存中有数据
                usleep(50000); //暂停50毫秒
            } while (!$redis->exists("user:{$user_id}"));

            $data = $redis->get("user:{$user_id}");
        }

        return $data;
    }


    public function index()
    {
        //设置缓存
        Cache::set('name', "ip:192.168.63.113", 3600);
        //读取缓存
        echo Cache::get('name');
        //删除缓存
        Cache::delete('name');
        //清空缓存
        Cache::clear();
    }


    /**
     * 测试获取订单编号
     */
    public function getSn()
    {
        $code = new Code();
        $orderSn = $code->getSn(1);
        echo $orderSn;
        die();
    }
}