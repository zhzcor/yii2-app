<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_comment}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property int $product_id 产品ID
 * @property string $images 图片
 * @property string $content 评论内容
 * @property string $rating 评分
 * @property int $created_at 创建时间
 */
class JnbComment extends CCmodel
{
    
    public $reply;
    public $replied_at;
    public $product;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_comment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'content'], 'required'],
            [['user_id', 'product_id', 'created_at'], 'integer'],
            [['content', 'rating'], 'string'],
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
            'images' => '图片',
            'content' => '评论内容',
            'rating' => '评分',
            'created_at' => '创建时间',
        ];
    }
}
