<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_cart}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property int $shop_id 店铺ID
 * @property int $product_id 产品ID
 * @property string $option 产品选项
 * @property int $quantity 数量
 * @property int $created_at 创建时间
 */
class JnbCart extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_cart}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'shop_id', 'product_id', 'quantity'], 'required'],
            [['user_id', 'shop_id', 'product_id', 'quantity', 'created_at'], 'integer'],
            [['option'], 'string', 'max' => 500],
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
            'shop_id' => '店铺',
            'product_id' => '产品',
            'option' => '产品选项',
            'quantity' => '数量',
            'created_at' => '创建时间',
        ];
    }
}
