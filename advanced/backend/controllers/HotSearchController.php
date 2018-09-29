<?php

namespace backend\controllers;

/**
 * Class HotSearchController 热搜管理 执行操作控制器
 * @package backend\controllers
 */
class HotSearchController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'common\models\JnbHotSearch';
     
    /**
     * 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        return [
            			'title' => 'like', 

        ];
    }
}
