<?php

namespace tests;

use Mockery as m;
use Mockery\MockInterface;
use think\App;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var App|MockInterface */
    protected $app;

    public function tearDown() : void
    {
        m::close();
    }

    protected function setUp() : void
    {
        $this->app = m::mock(App::class)->makePartial();
    }
}