<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admin_wallet_detail}}".
 *
 * @property int $id 主键ID
 * @property int $admin_id 管理员ID
 * @property int $wallet_id 钱包ID
 * @property string $money 交易金额
 * @property string $event 事件描述
 * @property string $carrier 事件载体
 * @property int $status 交易状态(0:交易未完成，1:交易成功，2:交易失败)
 * @property string $orderno 交易订单号
 * @property string $trade_content 交易明细
 * @property string $trade_result 交易结果
 * @property int $created_at 创建时间
 */
class AdminWalletDetail extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_wallet_detail}}';
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
            [['admin_id', 'wallet_id'], 'required'],
            [['admin_id', 'wallet_id', 'status', 'created_at'], 'integer'],
            [['money'], 'number'],
            [['trade_content', 'trade_result'], 'string'],
            [['event', 'carrier'], 'string', 'max' => 100],
            [['orderno'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => 'Admin ID',
            'wallet_id' => 'Wallet ID',
            'money' => 'Money',
            'event' => 'Event',
            'carrier' => 'Carrier',
            'status' => 'Status',
            'orderno' => 'Orderno',
            'trade_content' => 'Trade Content',
            'trade_result' => 'Trade Result',
            'created_at' => 'Created At',
        ];
    }
}
