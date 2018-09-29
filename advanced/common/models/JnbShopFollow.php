<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_shop_follow}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property int $shop_id 店铺ID
 * @property int $created_at 创建时间
 */
class JnbShopFollow extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_shop_follow}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'shop_id'], 'required'],
            [['user_id', 'shop_id', 'created_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'shop_id' => 'Shop ID',
            'created_at' => 'Created At',
        ];
    }
}
