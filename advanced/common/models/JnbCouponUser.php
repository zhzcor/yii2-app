<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_coupon_user}}".
 *
 * @property int $id 主键
 * @property int $user_id 用户ID
 * @property int $coupon_id 优惠卷ID
 * @property int $order_id 使用订单
 * @property int $status 状态(0:未使用,1:已使用,2:已删除)
 * @property int $valided 是否有效(0:无效,1:有效)
 * @property int $created_at 创建时间
 * @property int $used_at 使用时间
 */
class JnbCouponUser extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_coupon_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'coupon_id'], 'required'],
            [['user_id', 'coupon_id', 'order_id', 'status', 'valided', 'created_at', 'used_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'coupon_id' => '优惠卷',
            'order_id' => '使用订单',
            'status' => '状态',
            'valided' => '是否有效',
            'created_at' => '创建时间',
            'used_at' => '使用时间',
        ];
    }
}
