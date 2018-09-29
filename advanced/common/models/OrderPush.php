<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_push}}".
 *
 * @property int $id 主键ID
 * @property int $order_id 订单ID
 * @property int $user_id 推送用户
 * @property int $status 抢单状态(0:未抢单，1:已抢单)
 * @property int $created_at 推送时间
 * @property int $grabed_at 抢单时间
 */
class OrderPush extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_push}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id'], 'required'],
            [['order_id', 'user_id', 'status', 'created_at', 'grabed_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键ID',
            'order_id' => '订单ID',
            'user_id' => '用户ID',
            'status' => '状态',
            'created_at' => '推送时间',
            'grabed_at' => '抢单时间',
        ];
    }
}
