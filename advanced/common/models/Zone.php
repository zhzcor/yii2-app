<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%zone}}".
 *
 * @property int $id 主键ID
 * @property string $name 名称
 * @property int $pid 父ID
 * @property int $level 级别
 * @property string $area 所属区域
 * @property string $code 地区代码
 */
class Zone extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%zone}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['pid','level'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['area'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'pid' => '父ID',
            'level' => '级别',
            'area' => '所属区域',
            'code' => '地区代码',
        ];
    }
}
