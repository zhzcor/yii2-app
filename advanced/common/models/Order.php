<?php

namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;
use common\behaviors\UpdateBehavior;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id 主键ID
 * @property string $serial_no 订单流水号
 * @property int $user_id 寄件用户ID
 * @property int $rec_user_id 收件用户ID
 * @property int $delivery_user_id 送件用户ID
 * @property int $invoice_id 发票ID
 * @property int $rec_id 收货人ID
 * @property string $rec_name 收货人姓名
 * @property string $rec_telephone 收货人电话
 * @property string $rec_district 收货人地区
 * @property string $rec_district_id 收货人地区ID
 * @property string $rec_city 收货人城市
 * @property string $rec_city_id 收货人城市ID
 * @property string $rec_province 收货人省份
 * @property string $rec_province_id 收货人省份ID
 * @property string $rec_country 收货人国家
 * @property string $rec_country_id 收货人国家ID
 * @property string $rec_address 收货人地址
 * @property string $rec_house_number 收货人门牌号
 * @property string $rec_postcode 收货人邮编
 * @property string $rec_longitude 收货人经度
 * @property string $rec_latitude 收货人纬度
 * @property int $send_id 寄件人ID
 * @property string $send_name 寄件人姓名
 * @property string $send_telephone 寄件人电话
 * @property string $send_district 寄件人地区
 * @property string $send_district_id 寄件人地区ID
 * @property string $send_city 寄件人城市
 * @property string $send_city_id 寄件人城市ID
 * @property string $send_province 寄件人省份
 * @property string $send_province_id 寄件人省份ID
 * @property string $send_country 寄件人国家
 * @property string $send_country_id 寄件人国家ID
 * @property string $send_address 寄件人地址
 * @property string $send_house_number 寄件人门牌号
 * @property string $send_postcode 寄件人邮编
 * @property string $send_longitude 寄件人经度
 * @property string $send_latitude 寄件人纬度
 * @property int $international 是否国际
 * @property int $order_status_id 寄件/送件状态ID
 * @property int $rec_order_status_id 收件状态
 * @property string $payment_method 支付方式
 * @property string $payment_no 支付编号
 * @property string $goods_type 物品类型
 * @property string $net_weight 订单净重
 * @property string $images 订单图片
 * @property string $length 包裹长
 * @property string $width 包裹宽
 * @property string $height 包裹高
 * @property string $remark 备注信息
 * @property int $bulky 是否为泡货
 * @property string $pickup_time 取件时间
 * @property string $mileage 距离公里数
 * @property string $value_insured_price 保价险金额
 * @property string $lost_insured_price 丢失险金额
 * @property string $postfee 邮寄费
 * @property string $total 总金额
 * @property string $platform_fee 平台手续费金额
 * @property string $deliver_total 帮送员收益金额
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $finished_at 订单完成时间
 * @property int $deliveried_at 开始配送时间
 * @property int $arrived_at 帮送员确认送达时间
 * @property int $pushed_at 订单重推时间
 * @property int $pushed_times 订单重推次数
 */
class Order extends CCmodel
{
    
    public $receiver;
    public $sender;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    
    /**
     * getArrayStatus() 获取状态说明信息
     * @param integer|null $intStatus
     * @return array|string
     */
    public static function getArrayStatus($intStatus = null)
    {
        $statues = OrderStatus::find()->all();
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
            [['user_id', 'rec_user_id', 'delivery_user_id', 'invoice_id', 'rec_id', 'send_id', 'order_status_id', 'rec_order_status_id', 'bulky', 'created_at', 'updated_at','finished_at','international','deliveried_at','arrived_at','pushed_at','pushed_times'], 'integer'],
            [['net_weight', 'length', 'width', 'height', 'mileage', 'value_insured_price', 'lost_insured_price', 'postfee', 'total','platform_fee','deliver_total'], 'number'],
            [['rec_id','send_id','goods_type','net_weight','pickup_time','postfee','total','payment_method'], 'required'],
            [['serial_no','rec_name', 'rec_telephone', 'send_name', 'send_telephone'], 'string', 'max' => 32],
            [['rec_district', 'rec_city', 'rec_province', 'rec_country', 'send_district', 'send_city', 'send_province', 'send_country', 'payment_method', 'payment_no'], 'string', 'max' => 128],
            [['rec_district_id', 'rec_city_id', 'rec_province_id', 'rec_country_id', 'rec_postcode', 'send_district_id', 'send_city_id', 'send_province_id', 'send_country_id', 'send_postcode'], 'string', 'max' => 10],
            [['rec_address', 'send_address', 'remark'], 'string', 'max' => 500],
            [['send_house_number', 'rec_house_number'], 'string', 'max' => 128],
            [['rec_longitude', 'rec_latitude','send_longitude','send_latitude'], 'string', 'max' => 128],
            [['goods_type'], 'string', 'max' => 50],
            [['pickup_time'], 'string', 'max' => 20],
            [['images'], 'string'],
            ['rec_id', 'validateReceiver'],
            ['send_id', 'validateSender'],
            ['bulky' , 'validateBulky']
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
            'user_id' => '寄件用户ID',
            'rec_user_id' => '收件用户ID',
            'delivery_user_id' => '送件用户ID',
            'invoice_id' => '发票ID',
            'rec_id' => '收货人ID',
            'rec_name' => '收货人姓名',
            'rec_telephone' => '收货人电话',
            'rec_country' => '收货人国家',
            'rec_country_id' => '收货人国家ID',
            'rec_province' => '收货人省份',
            'rec_province_id' => '收货人省份ID',
            'rec_city' => '收货人城市',
            'rec_city_id' => '收货人城市ID',
            'rec_district' => '收货人地区',
            'rec_district_id' => '收货人地区ID',
            'rec_address' => '收货人地址',
            'rec_house_number' => '收货人门牌号',
            'rec_postcode' => '收货人邮编',
            'rec_longitude' => '收货人经度',
            'rec_latitude' => '收货人纬度',
            'send_id' => '寄件人ID',
            'send_name' => '寄件人姓名',
            'send_telephone' => '寄件人电话',
            'send_country' => '寄件人国家',
            'send_country_id' => '寄件人国家ID',
            'send_province' => '寄件人省份',
            'send_province_id' => '寄件人省份ID',
            'send_city' => '寄件人城市',
            'send_city_id' => '寄件人城市ID',
            'send_district' => '寄件人地区',
            'send_district_id' => '寄件人地区ID',
            'send_address' => '寄件人地址',
            'send_house_number' => '寄件人门牌号',
            'send_postcode' => '寄件人邮编',
            'send_longitude' => '寄件人经度',
            'send_latitude' => '寄件人纬度',
            'order_status_id' => '订单状态',
            'international' => '是否国际',
            'rec_order_status_id' => '收件状态',
            'payment_method' => '支付方式',
            'payment_no' => '支付编号',
            'goods_type' => '物品类型',
            'net_weight' => '订单重量',
            'images' => '物品图片',
            'length' => '包裹长',
            'width' => '包裹宽',
            'height' => '包裹高',
            'remark' => '备注信息',
            'bulky' => '是否为泡货',
            'pickup_time' => '取件时间',
            'mileage' => '距离(km)',
            'value_insured_price' => '保价险金额',
            'lost_insured_price' => '丢失险金额',
            'postfee' => '邮寄费',
            'total' => '订单总金额',
            'platform_fee' => '平台手续费金额',
            'deliver_total' => '帮送员收益金额',
            'finished_at' => '订单完成时间',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'deliveried_at' => '开始配送时间',
            'arrived_at' => '帮送员确认送达时间',
        ];
    }
    
    /**
     * 验证收货人是否存在
     * @param unknown $attribute
     * @param unknown $params
     */
    public function validateReceiver($attribute, $params){
        if(empty($this->id) && !$this->receiver = Receiver::findOne(['id'=>$this->rec_id , 'user_id'=>$this->user_id])){
            $this->addError($attribute, '收件人信息不存在');
        };
    }
    
    /**
     * 验证寄件人是否存在
     * @param unknown $attribute
     * @param unknown $params
     */
    public function validateSender($attribute, $params){
        if(empty($this->id) && !$this->sender = Sender::findOne(['id'=>$this->send_id , 'user_id'=>$this->user_id])){
            $this->addError($attribute, '寄件人信息不存在');
        };
    }
    
    public function validateBulky($attribute, $params){
        if($this->bulky == '1'){
            if(!floatval($this->width)){
                $this->addError('width', '泡货包裹长不能为空');
            }
            if(!floatval($this->height)){
                $this->addError('height', '泡货包裹宽不能为空');
            }
            if(!floatval($this->length)){
                $this->addError('length', '泡货包裹高不能为空');
            }
        }
    }
    
    
    /**
     * 按手机号查询是否有收货记录
     * @param unknown $telephone
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getReceiverOrders($telephone){
        return $this->find()->from('hc_order ho')->innerJoin('hc_receiver hr' , ' ho.rec_id=hr.id')
        ->where(['ho.rec_user_id'=>0,'hr.telephone'=>$telephone])
        ->select(['ho.id'])->asArray()->all();
    }
    
    
    
    public static function getSerialNo(){
        return date("ymdHis").rand(100000,999999);
    }
    
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert) {
                $this->serial_no   = $this::getSerialNo();
                $this->pushed_at   = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
