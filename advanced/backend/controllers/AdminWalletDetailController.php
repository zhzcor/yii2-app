<?php

namespace backend\controllers;

use Yii;
use common\models\AdminWallet;
use common\models\AdminWalletDetail;

/**
 * Class WalletDetail1Controller 账户交易明细 执行操作控制器
 * @package backend\controllers
 */
class AdminWalletDetailController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'common\models\AdminWalletDetail';
     
    /**
     * 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        
        return [
            'admin_id' => function($value){
                return ['wd.admin_id'=>$value];
            },
            'min-money'=> function($value){
                return ['>=', 'wd.money', $value];
            },
            'max-money'=> function($value){
                return ['<', 'wd.money', $value];
            },
            'telephone' => 'like',
            'event' => 'like',
            'carrier' => 'like',
            'created_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'wd.created_at', strtotime($times[0]) , strtotime($times[1])];
            },
            'orderno' => function ($value) {
                return ['like','wd.orderno',$value];
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
        return $model::find()->from('hc_admin_wallet_detail wd')
        ->select(['wd.id','wd.admin_id','wd.wallet_id','wd.money','wd.event','wd.carrier','wd.status','wd.orderno','wd.trade_content','wd.trade_result','wd.created_at'])->where($where)
        ->andWhere(['wd.status'=>'1'])->asArray();
    }
    
    /**
     * 显示视图
     * @return string
     */
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');
        $wallet = AdminWallet::findOne($id);
        Yii::$app->view->params['loadpart'] = true;	
        // 载入视图
        return $this->render('index', [
            'wallet' => $wallet,
            'status' => AdminWalletDetail::getArrayStatus(),    // 状态
            'statusColor' => AdminWalletDetail::getStatusColor(), // 状态对应颜色
        ]);
    }
}
