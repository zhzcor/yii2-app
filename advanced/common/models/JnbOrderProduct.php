<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_order_product}}".
 *
 * @property int $id 主键ID
 * @property int $order_id 订单ID
 * @property int $shop_id 店铺ID
 * @property int $product_id 产品ID
 * @property string $name 产品名称
 * @property int $quantity 产品数量
 * @property string $price 产品单价
 * @property string $total 产品总价
 * @property int $created_at 创建时间
 */
class JnbOrderProduct extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_order_product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'shop_id', 'product_id', 'name', 'quantity', 'price', 'total'], 'required'],
            [['order_id', 'shop_id', 'product_id', 'quantity', 'created_at'], 'integer'],
            [['price', 'total'], 'number'],
            [['name'], 'string', 'max' => 255],
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
            'shop_id' => '店铺',
            'product_id' => '产品',
            'name' => '产品名称',
            'quantity' => '产品数量',
            'price' => '产品单价',
            'total' => '产品总价',
            'created_at' => '创建时间',
        ];
    }
}
