<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_product_image}}".
 *
 * @property int $id 主键
 * @property int $product_id 产品ID
 * @property string $image 图片路径
 * @property int $sort 排序
 */
class JnbProductImage extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_product_image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'image'], 'required'],
            [['product_id', 'sort'], 'integer'],
            [['image'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'image' => 'Image',
            'sort' => 'Sort',
        ];
    }
}
