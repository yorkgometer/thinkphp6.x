<?php
// 全局中间件定义文件
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
     \think\middleware\SessionInit::class,

    //官方内置跨域请求中间件
    //\think\middleware\AllowCrossDomain::class,
    //自定义跨域请求中间件
    app\middleware\home\AllowCrossDomain::class
];
