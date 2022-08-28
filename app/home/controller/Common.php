<?php

namespace app\home\controller;

use app\BaseController;

class Common extends BaseController
{
    //静态模板生成目录
    protected $staticHtmlDir = "";
    //静态文件
    protected $staticHtmlFile = "";

    //判断是否存在静态
    public function beforeBuild($param = [])
    {
        //生成静态
        $this->staticHtmlDir = "html" . '/' . $this->request->controller() . '/';
        //参数md5
        $param = md5(json_encode($param));
        $this->staticHtmlFile = $this->staticHtmlDir . $this->request->action() . '_' . $param . '.html';

        //目录不存在，则创建
        if (!file_exists($this->staticHtmlDir)) {
            mkdir($this->staticHtmlDir);
        }

        //静态文件存在,并且没有过期
        if (file_exists($this->staticHtmlFile) && filectime($this->staticHtmlFile) >= time() - 60 * 60 * 24 * 5) {
            //echo '我是从静态文件获取';
            header("Location:/" . $this->staticHtmlFile);
            exit();
        }

    }

    //开始生成静态文件
    public function afterBuild($html)
    {
        if (!empty($this->staticHtmlFile) && !empty($html)) {
            if (file_exists($this->staticHtmlFile)) {
                \unlink($this->staticHtmlFile);
            }
            if (file_put_contents($this->staticHtmlFile, $html)) {
                header("Location:/" . $this->staticHtmlFile);
                exit();
            }
        }
    }
}