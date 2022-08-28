<?php

namespace app\home\controller\v1;

use app\home\controller\Common;

/**
 * @OA\Info(title="TP6.0企业最佳实践", version="1.0.1")
 */
class Article extends Common
{
    /**
     * @OA\Get(path="/v1/article",
     *   tags={"文章管理"},
     *   summary="文章列表",
     *   @OA\Parameter(name="token", in="header", description="token", @OA\Schema(type="string", default="123456")),
     *   @OA\Parameter(name="page", in="query", description="页码", @OA\Schema(type="int", default="1")),
     *   @OA\Parameter(name="limit", in="query", description="行数", @OA\Schema(type="int", default="10")),
     *   @OA\Response(response="200", description="The User")
     * )
     */
    public function index()
    {
        return '文章列表';
    }

    /**
     * @OA\Post(path="/v1/article",
     *   tags={"文章管理"},
     *   summary="新增文章",
     *   @OA\Parameter(name="token", in="header", description="token", @OA\Schema(type="string")),
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *         @OA\Schema(
     *           @OA\Property(description="文章名称", property="title", type="string", default="dd"),
     *           @OA\Property(description="文章内容", property="content", type="string"),
     *           required={"title", "content"})
     *       )
     *     ),
     *   @OA\Response(response="200", description="successful operation")
     * )
     */
    public function save()
    {
        //save业务代码
        return '新增文章';
    }

    /**
     * @OA\Get(path="/v1/article/{id}",
     *   tags={"文章管理"},
     *   summary="文章详情",
     *   @OA\Parameter(name="token", in="header", description="token", @OA\Schema(type="string")),
     *   @OA\Parameter(name="id", in="path", description="文章id", @OA\Schema(type="int")),
     *   @OA\Response(response="200", description="The User")
     * )
     */
    public function read($id)
    {
        //read业务代码
        return '文章详情';
    }

    /**
     * @OA\Put(path="/v1/article/{id}",
     *   tags={"文章管理"},
     *   summary="编辑文章",
     *   @OA\Parameter(name="token", in="header", description="token", @OA\Schema(type="string")),
     *   @OA\Parameter(name="id", in="path", description="文章id", @OA\Schema(type="int")),
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="content-type/json",
     *         @OA\Schema(
     *           @OA\Property(description="文章名称", property="title", type="string"),
     *           @OA\Property(description="文章内容", property="content", type="string"),
     *           required={"title", "content"})
     *       )
     *     ),
     *   @OA\Response(response="200", description="successful operation")
     * )
     */
    public function update($id)
    {
        //update业务代码
        return '编辑文章';
    }

    /**
     * @OA\Delete(path="/v1/article/{id}",
     *   tags={"文章管理"},
     *   summary="删除文章",
     *   @OA\Parameter(name="token", in="header", description="token", @OA\Schema(type="string")),
     *   @OA\Parameter(name="id", in="path", description="文章id", @OA\Schema(type="int")),
     *   @OA\Response(response="200", description="The User")
     * )
     */
    public function delete($id)
    {
        //delete业务代码
        return '删除文章';
    }

}