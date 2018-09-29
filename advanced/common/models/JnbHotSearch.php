<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_hot_search}}".
 *
 * @property int $id 主键
 * @property string $title 热搜名称
 * @property int $sort 排序
 */
class JnbHotSearch extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_hot_search}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['sort'], 'integer'],
            [['title'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '热搜名称',
            'sort' => '排序',
        ];
    }
}
