<?php

namespace app\home\controller;

use app\BaseController;

class Swagger extends BaseController
{
    public function swagger()
    {
        //扫描应用目录
        $swagger=\OpenApi\scan(__DIR__);
        //在public目录下生成swagger.json
        $res=$swagger->saveAs('./swagger.json');
    }
}