<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_history}}".
 *
 * @property int $id 主键ID
 * @property int $order_id 订单ID
 * @property int $order_status_id 订单状态
 * @property string $remark 备注
 * @property int $created_at 创建时间
 */
class OrderHistory extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_history}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'order_status_id'], 'required'],
            [['order_id', 'order_status_id', 'created_at'], 'integer'],
            [['remark'], 'string', 'max' => 255],
        ];
    }
    
    
    /**
     * 添加历史记录
     */
    public static function add($order_id  , $order_status_id , $remark = ''){
        $orderHistory = new OrderHistory();
        $orderHistory->order_id = $order_id;
        $orderHistory->order_status_id = $order_status_id;
        $orderHistory->remark = $remark;
        $orderHistory->created_at = time();
        return $orderHistory->save();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'order_status_id' => 'Order Status ID',
            'remark' => 'Remark',
            'created_at' => 'Created At',
        ];
    }
}
