<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_filter_group}}".
 *
 * @property int $id 主键ID
 * @property string $name 筛选组名称
 * @property int $sort 排序
 * @property int $created_at 创建时间
 */
class JnbFilterGroup extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_filter_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '筛选组名称',
            'sort' => '排序',
            'created_at' => '创建时间',
        ];
    }
}
