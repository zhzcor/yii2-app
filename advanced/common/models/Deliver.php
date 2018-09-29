<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%deliver}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property string $name 姓名
 * @property string $phone 联系电话
 * @property string $city 城市
 * @property int $city_id 城市ID
 * @property string $card_face 身份证正面
 * @property string $card_back 身份证反面
 * @property int $status 状态(0-待审核,1-审核通过,2-审核拒绝)
 * @property int $created_at 创建时间
 * @property int $reviewed_at 审核时间
 */
class Deliver extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%deliver}}';
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
            [['user_id', 'name', 'phone', 'city', 'card_face', 'card_back','id_card'], 'required'],
            [['user_id', 'city_id', 'status', 'created_at', 'reviewed_at','id_card'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
            [['city'], 'string', 'max' => 128],
/*            [['id_card'], 'string', 'max' => 20],*/
            [['country'], 'string', 'max' => 128],
            [['card_face', 'card_back'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'city' => 'City',
            'city_id' => 'City ID',
            'card_face' => 'Card Face',
            'card_back' => 'Card Back',
            'status' => 'Status',
            'created_at' => 'Create At',
            'reviewed_at' => 'Review At',
            'id_card'=>'Id Crad',
            'country'=>'Country',
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
    
    /**
     * 保存后操作
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterSave()
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if($insert) {
            $this->status = 0;
            $this->reviewed_at = time();
            $this->save();
            $user = User::findOne($this->user_id);
            $user->deliver = 3;
            $user->save();
        } 
    }
}
