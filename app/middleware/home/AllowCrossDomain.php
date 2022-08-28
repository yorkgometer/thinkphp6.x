<?php
declare (strict_types=1);

namespace app\middleware\home;

use think\Response;

class AllowCrossDomain
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        /*
         //方法1
         header('Access-Control-Allow-Origin: *');//允许所有来源访问
         header('Access-Control-Max-Age: 1800');
         header("Access-Control-Allow-Credentials:true");
         header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE');//允许访问的方式
         header('Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, Token');
         //OPTIONS请求，直接返回
         if (strtoupper($request->method()) == "OPTIONS") {
            return Response::create()->send();
         }
         return $next($request);
        */
        //方法2
        $origin = $request->header('Origin', '*');//*允许所有来源访问
        $response = $next($request);
        $response->header([
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Max-Age' => 1800,
            'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',//允许访问的方式
            'Access-Control-Allow-Credentials' => 'true',
            //'Access-Control-Allow-Headers' => '*',
            'Access-Control-Allow-Headers' => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, Token'
        ]);
        //OPTIONS请求，直接返回
        if (strtoupper($request->method(true)) == "OPTIONS") {
            exit('不允许OPTIONS请求');
        }
        return $response;
    }
}