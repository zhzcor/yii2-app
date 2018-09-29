<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_order_history}}".
 *
 * @property int $id 主键ID
 * @property int $order_id 订单ID
 * @property int $order_status_id 订单状态
 * @property string $remark 备注
 * @property int $created_at 创建时间
 */
class JnbOrderHistory extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_order_history}}';
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单ID',
            'order_status_id' => '订单状态',
            'remark' => '备注',
            'created_at' => '创建时间',
        ];
    }
}
