<?php

namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%receiver}}".
 *
 * @property int $id 主键唯一ID
 * @property int $user_id 用户ID
 * @property string $name 收货人姓名
 * @property string $telephone 收货人电话
 * @property string $district 收货人地区
 * @property string $district_id 收货人地区ID
 * @property string $city 收货人城市
 * @property string $city_id 收货人城市ID
 * @property string $province 收货人省份
 * @property string $province_id 收货人省份ID
 * @property string $country 收货人国家
 * @property string $country_id 收货人国家ID
 * @property string $address 收货人详细地址
 * @property string $postcode 收货人邮编
 * @property int $def 是否默认（0-否，1-是）
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $longitude 地址经度
 * @property int $latitude 地址纬度
 * @property string $house_number 门牌号
 * @property int $international 是否国际
 */
class Receiver extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%receiver}}';
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'telephone', 'address'], 'required'],
            [['user_id', 'def', 'created_at', 'updated_at','international'], 'integer'],
            [['name', 'telephone'], 'string', 'max' => 32],
            [['district', 'city', 'province', 'country'], 'string', 'max' => 128],
            [['district_id', 'city_id', 'province_id', 'country_id', 'postcode'], 'string', 'max' => 10],
            [['address'], 'string', 'max' => 500],
            [['house_number'], 'string', 'max' => 128],
            [['longitude','latitude'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'name' => '收件人姓名',
            'telephone' => '收件人电话',
            'district' => '收件人所在区',
            'district_id' => 'District ID',
            'city' => '收件人城市',
            'city_id' => 'City ID',
            'province' => '收件人省份',
            'province_id' => 'Province ID',
            'country' => '收件人国家',
            'country_id' => 'Country ID',
            'address' => '收件人详细地址',
            'postcode' => '收件人邮编',
            'def' => '是否默认',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'longitude' => '地址经度',
            'latitude' => '地址纬度',
            'house_number' => '门牌号',
            'international'=>'是否国际'
        ];
    }
}
