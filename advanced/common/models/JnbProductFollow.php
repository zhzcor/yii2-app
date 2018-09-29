<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_product_follow}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property int $product_id 产品ID
 * @property int $created_at 创建时间
 */
class JnbProductFollow extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_product_follow}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id', 'created_at'], 'integer'],
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
            'product_id' => '产品',
            'created_at' => '创建时间',
        ];
    }
}
