<?php

namespace backend\controllers;

/**
 * Class UserAccountController 用户账号 执行操作控制器
 * @package backend\controllers
 */
class UserAccountController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'common\models\UserAccount';
     
    /**
     * 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        return [
            'user_id' => function($value){
                return ['like' , 'u.telephone', $value];
            },
            'type' => function($value){
                return ['ua.type' => $value];
            },
            'fullname' => function($value){
                return ['like' , 'ua.fullname', $value];
            },
            'acc_number' => function($value){
                return ['like' , 'ua.acc_number', $value];
            },
            'created_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'ua.created_at', strtotime($times[0]) , strtotime($times[1])];
            },
        ];
    }
    
    
    /**
     * 获取查询对象(查询结果一定要为数组)
     *
     * @param mixed|array $where 查询条件
     * @return \yii\db\ActiveQuery 返回查询对象
     * @see actionSearch()
     * @see actionExport()
     */
    protected function getQuery($where)
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = $this->modelClass;
        return $model::find()->from('hc_user_account ua')->innerJoin('hc_user u' , 'ua.user_id=u.id')
        ->select(['ua.id','ua.type','u.telephone as user_id','ua.fullname','ua.acc_number','ua.created_at'])
        ->where($where)->asArray();
    }
}
