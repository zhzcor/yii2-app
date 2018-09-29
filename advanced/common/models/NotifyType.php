<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%notify_type}}".
 *
 * @property int $id 主键ID
 * @property string $code 类型代码
 * @property string $name 类型名称
 * @property int $sort 排序
 */
class NotifyType extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notify_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['sort'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'sort' => 'Sort',
        ];
    }
}
