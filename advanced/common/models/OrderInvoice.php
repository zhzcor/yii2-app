<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_invoice}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property int $order_id 订单ID
 * @property string $type 发票类型
 * @property string $money 发票金额
 * @property string $head 发票抬头
 * @property string $taxno 税号
 * @property string $acc_bank_name 开户行名称
 * @property string $acc_bank_number 开户行账号
 * @property string $reg_phone 注册电话
 * @property string $reg_address 注册地址
 * @property string $name 收票人姓名
 * @property string $phone 收票人电话
 * @property string $address 收票人地址
 * @property int $status 寄送状态(0:待寄,1:已寄)
 * @property int $posted_at 寄送时间
 * @property int $created_at 创建时间
 */
class OrderInvoice extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_invoice}}';
    }

    
    /**
     * getArrayStatus() 获取状态说明信息
     * @param integer|null $intStatus
     * @return array|string
     */
    public static function getArrayStatus($intStatus = null)
    {
        $array = [
            '0' => '开票中',
            '1' => '已开票',
            '2' => '开票失败',
        ];
        
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
            '0' => 'label-warning',
            '1' => 'label-success',
            '2' => 'label-danger',
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
            [['order_id', 'type' , 'head' ,'name', 'phone', 'address'], 'required'],
            [['user_id', 'status', 'posted_at', 'created_at'], 'integer'],
            [['money'], 'number'],
            [['type'], 'string', 'max' => 10],
            [['head', 'acc_bank_name', 'name'], 'string', 'max' => 100],
            [['order_id'], 'string', 'max' => 200],
            [['taxno', 'acc_bank_number'], 'string', 'max' => 50],
            [['reg_phone', 'phone'], 'string', 'max' => 20],
            [['reg_address', 'address'], 'string', 'max' => 255],
            ['type' , 'validateType'],
            ['order_id' , 'validateOrderid']
        ];
    }

    
    /**
     * 验证type与对应参数是否齐全
     * @param unknown $attribute
     * @param unknown $params
     */
    public function validateType($attribute, $params){
        if(!array_key_exists($this->type, Yii::$app->params['invoice_type'])){
            $this->addError($attribute, '发票类型错误');
        }else{
            if($this->type == 'normal'){
                if(!trim($this->taxno)){
                    $this->addError('taxno', '税号不能为空');
                }
            }elseif($this->type == 'profession'){
                if(!trim($this->taxno)){
                    $this->addError('taxno', '税号不能为空');
                }
                if(!trim($this->acc_bank_name)){
                    $this->addError('acc_bank_name', '开户行名称不能为空');
                }
                if(!trim($this->acc_bank_number)){
                    $this->addError('acc_bank_number', '开户行账号不能为空');
                }
                if(!trim($this->reg_address)){
                    $this->addError('reg_address', '注册地址不能为空');
                }
                if(!trim($this->reg_phone)){
                    $this->addError('reg_phone', '注册电话不能为空');
                }
            }
        }
    }
    
    /**
     * 验证type与对应参数是否齐全
     * @param unknown $attribute
     * @param unknown $params
     */
    public function validateOrderid($attribute, $params){
        if(empty($this->id)){
            $orderids = explode(',', $this->order_id);
            foreach ($orderids as $orderid){
                $orderInfo = Order::findOne($orderid);
                if(empty($orderInfo)){
                    $this->addError($attribute, $orderid.'订单不存在');
                    break;
                }elseif($orderInfo->user_id != Yii::$app->user->id){
                    $this->addError($attribute, $orderid.'订单不属于该用户');
                    break;
                }elseif(!empty($orderInfo->invoice_id)){
                    $this->addError($attribute, $orderid.'该订单已开具发票');
                    // break;/
                }
                $this->money += $orderInfo->total;
            }
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'order_id' => '订单ID',
            'type' => '发票类型',
            'money' => '发票金额',
            'head' => '发票抬头',
            'taxno' => '税号',
            'acc_bank_name' => '开户行名称',
            'acc_bank_number' => '开户行账号',
            'reg_phone' => '注册电话',
            'reg_address' => '注册地址',
            'name' => '收票人姓名',
            'phone' => '收票人电话',
            'address' => '收票人地址',
            'status' => '寄送状态',
            'posted_at' => '寄送时间',
            'created_at' => '创建时间',
            'eamil' => '邮箱地址',
        ];
    }
    
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$insert && $this->status == '1' && empty($this->posted_at)) {
                $this-> posted_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * 新增后执行
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterSave()
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if($insert) {
            // 全站用户
            $orderids = explode(',', $this->order_id);
            foreach ($orderids as $orderid){
                $orderInfo = Order::findOne($orderid);
                $orderInfo->invoice_id = $this->id;
                $orderInfo->save();
            }
        } else {
        }
    }
}
