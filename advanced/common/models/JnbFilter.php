<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_filter}}".
 *
 * @property int $id 主键ID
 * @property int $group_id 选项组
 * @property string $name 筛选名称
 * @property int $sort 排序
 * @property int $created_at 创建时间
 */
class JnbFilter extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_filter}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'name'], 'required'],
            [['group_id', 'sort', 'created_at'], 'integer'],
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
            'group_id' => '选项组',
            'name' => '筛选名称',
            'sort' => '排序',
            'created_at' => '创建时间',
        ];
    }
}
