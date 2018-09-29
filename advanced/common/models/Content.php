<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%content}}".
 *
 * @property int $id 主键ID
 * @property string $title 标题
 * @property string $image 图片
 * @property string $content 内容
 * @property int $created_at 创建时间
 */
class Content extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%content}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['image','content'], 'string'],
            [['created_at'], 'integer'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'image' => '图片',
            'content' => '文字内容',
            'created_at' => '创建时间',
        ];
    }
}
