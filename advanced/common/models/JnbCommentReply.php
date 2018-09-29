<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_comment_reply}}".
 *
 * @property int $id 主键ID
 * @property int $product_id 产品ID
 * @property int $comment_id 评论ID
 * @property string $content 回复内容
 * @property int $created_at 创建时间
 */
class JnbCommentReply extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_comment_reply}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'comment_id', 'content'], 'required'],
            [['product_id', 'comment_id', 'created_at'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => '产品',
            'comment_id' => '评论',
            'content' => '回复内容',
            'created_at' => '创建时间',
        ];
    }
}
