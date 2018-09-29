<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_product_category}}".
 *
 * @property int $product_id 产品ID
 * @property int $category_id 分类ID
 */
class JnbProductCategory extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_product_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'category_id'], 'required'],
            [['product_id', 'category_id'], 'integer'],
            [['product_id', 'category_id'], 'unique', 'targetAttribute' => ['product_id', 'category_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'category_id' => 'Category ID',
        ];
    }
}
