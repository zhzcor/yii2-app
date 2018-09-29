<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_order}}".
 *
 * @property int $id 主键ID
 * @property string $serial_no 订单流水号
 * @property int $user_id 用户ID
 * @property int $admin_id 后台管理员ID
 * @property int $address_id 地址ID
 * @property string $name 姓名
 * @property string $telephone 电话
 * @property string $province 省份
 * @property string $city 城市
 * @property string $district 地区
 * @property string $address 详细地址
 * @property string $house_number 门牌号
 * @property string $postcode 邮编
 * @property int $order_status_id 订单状态
 * @property string $payment_method 支付方式
 * @property string $payment_no 支付编号
 * @property string $remark 备注信息
 * @property string $service_time 服务时间
 * @property string $total_money 产品总金额
 * @property string $total 实际支付金额
 * @property string $coupon_money 优惠卷金额
 * @property string $platform_fee 平台手续费金额
 * @property string $shop_total 店铺收益金额
 * @property int $finished_at 定单完成时间
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class JnbOrder extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_order}}';
    }
    
    
    /**
     * getArrayStatus() 获取状态说明信息
     * @param integer|null $intStatus
     * @return array|string
     */
    public static function getArrayStatus($intStatus = null)
    {
        $statues = JnbOrderStatus::find()->all();
        $array = [];
        foreach ($statues as $status){
            $array[$status->id] = $status->name;
        }
        
        if ($intStatus !== null && isset($array[$intStatus])) {
            $array = $array[$intStatus];
        }
        
        return $array;
    }
    
    /**
     * getStatusColor() 获取状态值对应颜色信息
     * @param null $intStatus
     * @return array|mixed
     */
    public static function getStatusColor($intStatus = null)
    {
        $array = [
            '10' => 'label-warning',
            '20' => 'label-info',
            '30' => 'label-success',
            '40' => 'label-success',
            '50' => 'label-success',
            '60' => 'label-warning',
            '70' => 'label-success',
            '80' => 'label-success',
        ];
        
        if ($intStatus !== null && isset($array[$intStatus])) {
            $array = $array[$intStatus];
        }
        
        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'address_id', 'order_status_id','admin_id'], 'integer'],
            [['name', 'telephone', 'province', 'city', 'district', 'address', 'house_number'], 'required'],
            [['total_money', 'total', 'coupon_money', 'platform_fee', 'shop_total'], 'number'],
            [['serial_no', 'name', 'telephone'], 'string', 'max' => 32],
            [['province', 'city', 'district', 'house_number', 'payment_method', 'payment_no'], 'string', 'max' => 128],
            [['address', 'remark'], 'string', 'max' => 255],
            [['postcode'], 'string', 'max' => 10],
            [['service_time'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial_no' => '订单流水号',
            'user_id' => '用户',
            'address_id' => '地址ID',
            'name' => '姓名',
            'telephone' => '电话',
            'province' => '省份',
            'city' => '城市',
            'district' => '地区',
            'address' => '详细地址',
            'house_number' => '门牌号',
            'postcode' => '邮编',
            'order_status_id' => '订单状态',
            'payment_method' => '支付方式',
            'payment_no' => '支付编号',
            'remark' => '备注信息',
            'service_time' => '服务时间',
            'total_money' => '产品总金额',
            'total' => '支付金额',
            'coupon_money' => '优惠卷金额',
            'platform_fee' => '平台手续费金额',
            'shop_total' => '店铺收益金额',
            'finished_at' => '定单完成时间',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
