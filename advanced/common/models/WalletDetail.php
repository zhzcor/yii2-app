<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%wallet_detail}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property int $wallet_id 钱包ID
 * @property int $shop_id 店铺ID
 * @property int $type 类型
 * @property int $money 交易金额
 * @property string $event 事件描述
 * @property int $status 交易状态
 * @property int $created_at 创建时间
 * @property string $orderno 交易订单号
 * @property string $trade_content 交易明细
 * @property string $trade_result 交易结果
 * @property int $created_at 创建时间
 */
class WalletDetail extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wallet_detail}}';
    }
    
    /**
     * getArrayStatus() 获取状态说明信息
     * @param integer|null $intStatus
     * @return array|string
     */
    public static function getArrayStatus($intStatus = null)
    {
        $array = [
            '0' => '未完成',
            '1' => '交易成功',
            '2' => '交易失败',
        ];
        
        if ($intStatus !== null && isset($array[$intStatus])) {
            $array = $array[$intStatus];
        }
        
        return $array;
    }
    
    /**
     * getStatusColor() 获取状态值对应颜色信息
     * @param null $intStatus
     * @return array|mixed
     */
    public static function getStatusColor($intStatus = null)
    {
        $array = [
            '0' => 'label-warning',
            '1' => 'label-success',
            '2' => 'label-warning',
        ];
        
        if ($intStatus !== null && isset($array[$intStatus])) {
            $array = $array[$intStatus];
        }
        
        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['money','carrier'], 'required'],
            [['user_id', 'wallet_id','shop_id', 'created_at','status'], 'integer'],
            [['money'] , 'number'],
            [['trade_content','trade_result'] , 'string'],
            [['event', 'carrier'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 10],
            [['orderno'], 'string', 'max' => 100],
        ];
    }

    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'wallet_id' => 'Wallet ID',
            'shop_id' => '店铺',
            'type' => '类型',
            'money' => '金额',
            'event' => '交易事件',
            'carrier' => '交易平台',
            'status' => '交易状态',
            'orderno' => '交易订单号',
            'trade_content' => '交易明细',
            'trade_result' => '交易结果',
            'created_at' => '创建时间',
        ];
    } 
    
    public static function add($data){
        $walletDetail = new WalletDetail();
        $walletDetail->user_id = isset($data['user_id']) ? $data['user_id'] : Yii::$app->user->id;
        $walletDetail->wallet_id = $data['wallet_id'];
        $walletDetail->type = isset($data['type']) ? $data['type'] : 'logistic';
        $walletDetail->shop_id = isset($data['shop_id']) ? $data['shop_id'] : 0;
        $walletDetail->money = $data['money'];
        $walletDetail->event = $data['event'];
        $walletDetail->carrier = $data['carrier'];
        $walletDetail->status = isset($data['status']) ? $data['status'] : 0;
        if(!empty($data['orderno'])){
            $walletDetail->orderno       = $data['orderno'];
            $walletDetail->trade_content = isset($data['content']) ? $data['content'] : '';
            $walletDetail->trade_result  = isset($data['result']) ? $data['result'] : '';
        }
        $walletDetail->save();
        return $walletDetail;
    }
}
