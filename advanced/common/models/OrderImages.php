<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_images}}".
 *
 * @property int $id 主键ID
 * @property int $order_id 订单ID
 * @property string $image 图片路径
 * @property int $created_at 创建时间
 */
class OrderImages extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['order_id', 'created_at'], 'integer'],
            [['image'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'image' => 'Image',
            'created_at' => 'Create At',
        ];
    }
}
