<?php

namespace app\common\exception;


use think\exception\Handle;
use think\Response;
use Throwable;

class Http extends Handle
{

    public function render($request, Throwable $e): Response
    {
        // 请求异常
        if ($request->isAjax()) {
            show(30000, $e->getMessage(), [], 500);
        } else {
            exit('异常: ' . $e->getMessage());
        }

    }

}