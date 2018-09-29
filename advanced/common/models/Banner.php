<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @property int $id 主键ID
 * @property string $type banner类型
 * @property string $title 标题
 * @property string $image 图片路径
 * @property int $sort 排序
 * @property int $created_at 创建时间
 */
class Banner extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'title', 'image'], 'required'],
            [['sort', 'created_at'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['title', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型',
            'title' => '标题',
            'image' => '图片',
            'sort' => '排序',
            'created_at' => '创建时间',
        ];
    }
}
