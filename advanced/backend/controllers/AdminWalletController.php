<?php

namespace backend\controllers;

use Yii;
use common\models\AdminWalletDetail;
use common\models\AdminWallet;
/**
 * Class AdminWalletController 账户管理 执行操作控制器
 * @package backend\controllers
 */
class AdminWalletController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'common\models\AdminWallet';
     
    /**
     * 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        return [
            'admin' => function ($value) {
                return ['like', 'a.username', $value];
            },
            'min-money'=> function($value){
                return ['>=', 'w.money', $value];
            },
            'max-money'=> function($value){
                return ['<', 'w.money', $value];
            },
            'updated_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'w.updated_at', strtotime($times[0]) , strtotime($times[1])];
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
        $query = $model::find()->from('hc_admin a')->innerJoin('hc_admin_wallet w' , 'a.id=w.admin_id')
        ->select(['w.id','a.username AS admin_id','w.money','w.updated_at'])
        ->where($where);
        if(Yii::$app->user->identity->role == 'merchant'){
            $query->andWhere(['a.id'=>Yii::$app->user->id]);
        }
        return $query->asArray();
    }
    
    
    /**
     * 交易明细
     * @param unknown $id
     */
    public function actionDetail($id){
        $wallet = AdminWallet::findOne($id);
        return $this->renderAjax('detail' , [
            'wallet' => $wallet
        ]);
    }
    
    /**
     * 充值
     * @param unknown $id
     */
    public function actionRecharge($id){
        
        return $this->renderAjax('recharge' , [
        ]);
    }
    
    /**
     * 提现
     * @param unknown $id
     */
    public function actionTransfer($id){
        
        return $this->renderAjax('transfer' , [
        ]);
    }
}
