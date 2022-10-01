<?php


namespace app\home\controller\v1;

use app\BaseController;

class Good extends BaseController
{
    public function getList()
    {
        //获取到内存中所有表信息
        var_dump(app("think\\swoole\\table"));
        echo "<br>";

        //获取到具体某张表信息,返回Swoole/Table对象
        $goods = app("swoole.table.goods");
        var_dump($goods);
        echo "<br>";

        //向表中添加一行
        //设置行的数据Swoole\Table->set(string $key, array $value): bool;
        //string $key 相同的 $key 对应同一行数据，如果 set 同一个 key，会覆盖上一次的数据，key 最大长度不得超过 63 字节
        //array $value 必须是一个数组，必须与字段定义的 $name 完全相同
        $goods->set('5cc0448eCuu9Ta', [
            'id' => 1,
            'sku' => "5cc0448eCuu9Ta",
            'kucun' => 4
        ]);

        //获取goods表中key=5cc0448eCuu9Ta的记录
        var_dump($goods->get('5cc0448eCuu9Ta'));
        echo "<br>";

        //模拟用户下单，商品库存减一
        $goods->decr('5cc0448eCuu9Ta', 'kucun', 1);

        //获取goods表中此时key=5cc0448eCuu9Ta的记录
        var_dump($goods->get('5cc0448eCuu9Ta'));
    }
}