<?php

namespace app\home\controller\v1;

use app\home\controller\Common;
use think\facade\View;


class User extends Common
{
    /*
    public function getlist(){
        return "this is v1 home/v1/user/getlist";
    }
    */

    public function getList($id = '')
    {
        //判断静态界面是否存在
        $this->beforeBuild(array($id));
        //dd('静态页面存在，不好走下面逻辑,否则执行下面逻辑创建静态文件');
        $name = "测试静态化";
        $html = View::fetch('/get_list', ['name' => $name]);
        //生成静态界面
        $this->afterBuild($html);
        return $html;
    }

}