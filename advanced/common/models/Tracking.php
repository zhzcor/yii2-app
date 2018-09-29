<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tracking}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 送件用户ID
 * @property string $longitude 轨迹经度
 * @property string $latitude 轨迹纬度
 * @property int $created_at 创建时间
 */
class Tracking extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tracking}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'longitude', 'latitude'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['longitude', 'latitude'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户编号',
            'longitude' => '轨迹经度',
            'latitude' => '轨迹纬度',
            'created_at' => '创建时间',
        ];
    }
}
