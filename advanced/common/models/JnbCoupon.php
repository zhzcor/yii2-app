<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_coupon}}".
 *
 * @property int $id 主键ID
 * @property int $shop_id 店铺ID
 * @property string $name 优惠卷名称
 * @property string $describe 优惠卷描述
 * @property string $type 类型
 * @property string $money 面额
 * @property int $send_num 发送数量(0:不限)
 * @property int $receive_num 领取数量
 * @property string $min_amount 最低消费金额
 * @property int $send_start_at 开始发放时间
 * @property int $send_end_at 结束发放时间
 * @property int $valid_start_at 活动开始时间
 * @property int $valid_end_at 活动结束时间
 * @property int $status 状态(0:停用,1:启用)
 * @property int $created_at 创建时间
 */
class JnbCoupon extends CCmodel
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_coupon}}';
    }

    
    /**
     * getArrayStatus() 获取状态说明信息
     * @param integer|null $intStatus
     * @return array|string
     */
    public static function getArrayStatus($intStatus = null)
    {
        $array = [
            '1' => '启用',
            '0' => '禁用',
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
            '1' => 'label-success',
            '0' => 'label-warning',
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
            [['shop_id', 'name', 'money', 'send_start_at', 'valid_start_at'], 'required'],
            [['shop_id', 'send_num', 'receive_num', 'status'], 'integer'],
            [['money', 'min_amount'], 'number'],
            [['name'], 'string', 'max' => 200],
            [['send_end_at','valid_end_at'], 'string'],
            [['describe'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
            ['send_end_at' , 'validateSendEndAt'],
            ['valid_end_at' , 'validateValidEndAt'],
            ['money' , 'validateMoney'],
        ];
    }
    
    
    /**
     * 验证
     * @param unknown $attribute
     * @param unknown $params
     */
    public function validateSendEndAt($attribute, $params){
        if(!empty($this->send_end_at) && $this->send_start_at > $this->send_end_at){
            $this->addError($attribute, '结束发放时间不能小于开始发放时间');
        };
    }
    
    /**
     * 验证
     * @param unknown $attribute
     * @param unknown $params
     */
    public function validateValidEndAt($attribute, $params){
        if(!empty($this->valid_end_at) && $this->valid_start_at > $this->valid_end_at){
            $this->addError($attribute, '活动结束时间不能小于活动开始时间 ');
        }elseif(!empty($this->valid_end_at) && $this->send_start_at > $this->valid_end_at){
            $this->addError($attribute, '活动结束时间不能小于开始发放时间 ');
        };
    }
    
    /**
     * 验证
     * @param unknown $attribute
     * @param unknown $params
     */
    public function validateMoney($attribute, $params){
        if(floatval($this->money) <= 0){
            $this->addError($attribute, '面额必须大于0');
        };
        if(floatval($this->send_num) < 0){
            $this->addError($attribute, '发送数量不能小于0');
        };
    }
    
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->send_start_at)) $this->send_start_at = strtotime($this->send_start_at);
            if (!empty($this->send_end_at)) $this->send_end_at = strtotime($this->send_end_at);
            if (!empty($this->valid_start_at)) $this->valid_start_at = strtotime($this->valid_start_at);
            if (!empty($this->valid_end_at)) $this->valid_end_at = strtotime($this->valid_end_at);
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => '店铺',
            'name' => '优惠卷名称',
            'describe' => '优惠卷描述',
            'type' => '类型',
            'money' => '面额',
            'send_num' => '发送数量',
            'receive_num' => '领取数量',
            'min_amount' => '最低消费金额',
            'send_start_at' => '开始发放时间',
            'send_end_at' => '结束发放时间',
            'valid_start_at' => '活动开始时间',
            'valid_end_at' => '活动结束时间',
            'status' => '状态',
            'created_at' => '创建时间',
        ];
    }
}
