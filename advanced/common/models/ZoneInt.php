<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%zone_int}}".
 *
 * @property int $id ID
 * @property string $name 名称
 * @property string $namezh 中文名称
 * @property int $pid 父ID
 * @property int $level 级别(1:国家,2:省,3:市,4:区)
 * @property string $code 地区代码
 */
class ZoneInt extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%zone_int}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'level'], 'required'],
            [['pid', 'level'], 'integer'],
            [['name','namezh'], 'string', 'max' => 200],
            [['code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'namezh' => 'Namezh',
            'pid' => 'Pid',
            'level' => 'Level',
            'code' => 'Code',
        ];
    }
}
