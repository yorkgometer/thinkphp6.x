<?php

namespace app\home\controller\v1;

use app\BaseController;

class Swagger extends BaseController
{
    //输出swagger.json内容
    public function swagger()
    {
        //扫描应用目录
        //你想要app/home/controller/v1文件夹下面的注释生成对应的API文档，因为echo __DIR__ 输出：/www/wwwroot/thinkphp6.x/app/home/controller/v1
        $openapi = \OpenApi\scan(__DIR__);
        //这个针对是所有应用，包括前后台的，因为echo (root_path().'app') 输出：/www/wwwroot/thinkphp6.x/app;
        //$openapi = \OpenApi\scan(root_path() . 'app');
        header('Content-Type: application/json');
        echo $openapi->toJson();
    }

    //在public目录下生成swagger.json文件
    public function swaggerjson()
    {
        //扫描应用目录
        //你想要app/home/controller/v1文件夹下面的注释生成对应的API文档，因为echo __DIR__ 输出：/www/wwwroot/thinkphp6.x/app/home/controller/v1
        $openapi = \OpenApi\scan(__DIR__);
        //这个针对是所有应用，包括前后台的，因为echo (root_path().'app') 输出：/www/wwwroot/thinkphp6.x/app;
        //$openapi = \OpenApi\scan(root_path() . 'app');
        //在public目录下生成swagger.json
        $openapi->saveAs('./swagger.json');
        //return 'swagger.json生成成功';
        //生成完成跳转到swagger首页
        return redirect('http://www.thinkphp6.x.com/dist/index.html');
    }

}