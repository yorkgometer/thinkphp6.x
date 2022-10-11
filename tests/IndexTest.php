<?php
namespace tests;

use app\controller\Index;

/**
 * 测试类
 * @package tests
 */
class IndexTest extends TestCase
{
    /**
     * 测试欢迎页
     */
    public function testIndex()
    {
        $controller = new Index($this->app);
        $this->assertEquals('hello', $controller->index());
    }
}