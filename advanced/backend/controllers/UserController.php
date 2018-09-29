<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\AdminLog;
use common\helpers\Helper;
use common\models\Wallet;
use yii\helpers\BaseJson;

/**
 * Class UserController 用户信息
 * @package backend\controllers
 */
class UserController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'backend\models\User';

    /**
     * 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        return [
            'id' => function($value){
                return ['u.id'=>$value];
            },
            'telephone' => 'like',
            'nickname' => 'like',
            'sex' => '=',
            'status' => '=',
        ];
    }

    /**
     * 首页显示
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'status' => User::getArrayStatus(),
            'statusColor' => User::getStatusColor(),
        ]);
    }

    
    /**
     * 处理新增数据
     * @return mixed|string
     */
    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        if (empty($data)) {
            return $this->error(201);
        }
        
        // 实例化出查询的model
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass();
        
        // 验证是否定义了创建对象的验证场景
        $arrScenarios = $model->scenarios();
        if (isset($arrScenarios['create'])) {
            $model->scenario = 'create';
        }
        
        // 对model对象各个字段进行赋值
        $this->arrJson['errCode'] = 205;
        if (!$model->load($data, '')) {
            return $this->error(205);
        }
        // 判断修改返回数据
        if ($model->save()) {
            //创建钱包
            $wallet = new Wallet();
            $wallet->user_id = $model->id;
            $wallet->save();
            $model->wallet_id = $wallet->id;
            $model->save();
            $this->handleJson($model);
            $pk = $this->pk;
            AdminLog::create(AdminLog::TYPE_CREATE, $data, $this->pk . '=' . $model->$pk);
            return $this->success($model);
        } else {
            return $this->error(1001, Helper::arrayToString($model->getErrors()));
        }
    }
    
    
    /**
     * 处理导出数据显示的问题
     * @return array
     */
    public function getExportHandleParams()
    {
        $array['created_at'] = $array['updated_at'] = function ($value) {
            return date('Y-m-d H:i:s', $value);
        };

        return $array;
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
        return $model::find()->from('hc_user u')->innerJoin('hc_wallet w' , 'u.id=w.user_id')
        ->select(['u.id','u.username','u.nickname','u.telephone','u.password_hash','u.password_reset_token','u.sex','u.avatar','u.email','u.status','u.access_token','u.wallet_id','u.auth_key','u.deliver','u.longitude','u.latitude','u.position_time','u.created_at','u.updated_at','w.money','w.updated_at as costed_at'])
        ->where($where)->asArray();
    }
    
    
    /**
     * 充值
     */
    public function actionRecharge($id){
        $user = User::findOne($id);
        $request = Yii::$app->request;
        if($request->isAjax){
            if(!floatval($request->post('money'))){
                return $this->error(1001, '请输入充值金额');
            }
            $wallet = Wallet::findOne(['user_id'=>$id]);
            $wallet->money = floatval($wallet->money) + floatval($request->post('money'));
            $wallet->save();
            return $this->success($wallet , '充值成功');
        }
        return $this->renderAjax('recharge' , [
            'user' => $user
        ]);
    }
    
    /**
     * 用户自动补全查询
     */
    public function actionAutocomplete(){
        $val = Yii::$app->request->post('val');
        if(trim($val)){
            $userList = User::find()->select(['id','telephone'])->where(['like' , 'telephone' , trim($val)])->limit(20)->asArray()->all();
            if($userList){
                return BaseJson::encode($userList);
            }else{
                return BaseJson::encode([['id'=>'' , 'telephone'=>'无搜索用户']]);
            }
        }else{
            return BaseJson::encode([['id'=>'' , 'telephone'=>'请输入用户手机号']]);
        }
    }
}
