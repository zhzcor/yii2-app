<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_address}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property string $name 姓名
 * @property string $telephone 电话
 * @property string $province 省份
 * @property string $city 城市
 * @property string $district 地区
 * @property string $address 详细地址
 * @property string $house_number 门牌号
 * @property string $postcode 邮编
 * @property int $def 是否默认（0-否，1-是）
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class JnbAddress extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'telephone', 'address'], 'required'],
            [['user_id', 'def', 'created_at', 'updated_at'], 'integer'],
            [['name', 'telephone'], 'string', 'max' => 32],
            [['province', 'city', 'district', 'house_number'], 'string', 'max' => 128],
            [['address'], 'string', 'max' => 500],
            [['postcode'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'name' => '姓名',
            'telephone' => '电话',
            'province' => '省份',
            'city' => '城市',
            'district' => '地区',
            'address' => '详细地址',
            'house_number' => '门牌号',
            'postcode' => '邮编',
            'def' => '是否默认',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
