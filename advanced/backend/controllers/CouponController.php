<?php

namespace backend\controllers;

use Yii;
use common\models\JnbCoupon;
use common\models\JnbShop;
use yii\helpers\ArrayHelper;

/**
 * Class CouponController 优惠卷管理 执行操作控制器
 * @package backend\controllers
 */
class CouponController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'common\models\JnbCoupon';
     
    /**
     * 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        return [
            'shop' => function($value){
                return ['like', 's.name', $value];
            },
            'name' => function($value){
                return ['like','c.name' , $value];
            },
            'type' => function($value){
                return ['c.type'=>$value];
            },
            'status' => function($value){
                return ['c.status'=>$value];
            },
            'min-money'=> function($value){
                return ['>=', 'c.money', $value];
            },
            'max-money'=> function($value){
                return ['<', 'c.money', $value];
            },
            'min-send_num'=> function($value){
                return ['>=', 'c.send_num', $value];
            },
            'max-send_num'=> function($value){
                return ['<', 'c.send_num', $value];
            },
            'min-receive_num'=> function($value){
                return ['>=', 'c.receive_num', $value];
            },
            'max-receive_num'=> function($value){
                return ['<', 'c.receive_num', $value];
            },
            'min-min_amount'=> function($value){
                return ['>=', 'c.min_amount', $value];
            },
            'max-min_amount'=> function($value){
                return ['<', 'c.min_amount', $value];
            },
            'send_start_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'c.send_start_at', strtotime($times[0]) , strtotime($times[1])];
            },
            'valid_start_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'c.valid_start_at', strtotime($times[0]) , strtotime($times[1])];
            },
            'created_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'c.created_at', strtotime($times[0]) , strtotime($times[1])];
            },
        ];
    }
    
    /**
     * 显示视图
     * @return string
     */
    public function actionIndex()
    {
        //$this->admins
        $query = JnbShop::find()->where(['status'=>1]);
        if(Yii::$app->user->identity->role == 'merchant'){
            $query->andWhere(['admin_id'=>Yii::$app->user->id]);
        }
        $shopList = $query->all();
        $shops = ArrayHelper::map($shopList, 'id', 'name');
        // 载入视图
        return $this->render('index', [
            'status' => JnbCoupon::getArrayStatus(),    // 状态
            'statusColor' => JnbCoupon::getStatusColor(), // 状态对应颜色
            'shops' => $shops
        ]);
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
        $query = $model::find()->from('hc_jnb_coupon c')->leftJoin('hc_jnb_shop s' , 'c.shop_id=s.id')->select(['c.id','s.name AS shop_id','c.name','c.describe','c.type','c.money','c.send_num','c.receive_num','c.min_amount','c.send_start_at','c.send_end_at','c.valid_start_at','c.valid_end_at','c.status','c.created_at'])
        ->where($where);
        if(Yii::$app->user->identity->role == 'merchant'){
            $query->where(['s.admin_id'=>Yii::$app->user->id]);
        }
        return $query->asArray();
    }
}
