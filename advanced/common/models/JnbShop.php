<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_shop}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 创建者
 * @property int $admin_id 后台用户ID
 * @property string $name 店铺名称
 * @property string $image 店铺图片
 * @property string $business_scope 营业范围
 * @property string $business_hours 营业时间
 * @property string $charge_person 负责人
 * @property string $cardid 负责人身份证号
 * @property string $telephone 负责人联系电话
 * @property string $position 店铺位置
 * @property string $ship_address 详细地址
 * @property string $service_scope 店铺服务范围
 * @property string $card_face 身份证正面
 * @property string $card_back 身份证反面
 * @property string $business_license 营业执照正面
 * @property int $status 状态(0:待审核,1:审核通过,2:审核拒绝)
 * @property string $remark 审核备注
 * @property int $rating 评分
 * @property int $receive_total 接收单量
 * @property int $order_total 接单数
 * @property int $praise_rate 好评率
 * @property int $created_at 创建时间
 * @property int $reviewed_at 审核时间
 */
class JnbShop extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_shop}}';
    }

    /**
     * getArrayStatus() 获取状态说明信息
     * @param integer|null $intStatus
     * @return array|string
     */
    public static function getArrayStatus($intStatus = null)
    {
        $array = [
            '0' => '未处理',
            '1' => '审核通过',
            '2' => '审核拒绝',
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
            '0' => 'label-primary',
            '2' => 'label-warning',
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
            [['user_id','name', 'business_scope', 'business_hours', 'charge_person', 'cardid', 'telephone', 'position', 'ship_address', 'service_scope', 'card_face', 'card_back', 'business_license'], 'required'],
            [['user_id' , 'admin_id','status', 'rating' , 'receive_total' ,'order_total', 'praise_rate', 'created_at', 'reviewed_at'], 'integer'],
            [['name', 'business_hours', 'charge_person'], 'string', 'max' => 100],
            [['business_scope', 'position', 'ship_address', 'service_scope', 'remark'], 'string', 'max' => 255],
            [['cardid'], 'string', 'max' => 18,],
            [['telephone'], 'string', 'max' => 20],
            [['card_face', 'card_back', 'business_license','image'], 'string'],
        ];
    }
    
    public static function getName($id){
        return JnbShop::findOne($id)->name;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '创建者',
            'admin_id' => '后台用户ID',
            'name' => '店铺名称',
            'image' => '店铺图片',
            'business_scope' => '营业范围',
            'business_hours' => '营业时间',
            'charge_person' => '负责人',
            'cardid' => '负责人身份证号',
            'telephone' => '负责人联系电话',
            'position' => '店铺位置',
            'ship_address' => '详细地址',
            'service_scope' => '店铺服务范围',
            'card_face' => '身份证正面',
            'card_back' => '身份证反面',
            'business_license' => '营业执照正面',
            'status' => '状态',
            'remark' => '审核备注',
            'rating' => '评分',
            'receive_total' => '接收单量',
            'order_total' => '接单数',
            'praise_rate' => '好评率',
            'created_at' => '创建时间',
            'reviewed_at' => '审核时间',
        ];
    }
    
    /**
     * 保存前操作
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterSave()
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$insert && $this->status != '0' && empty($this->reviewed_at)) {
                $this-> reviewed_at = time();
            }
            return true;
        } else {
            return false;
        }
    }

}
