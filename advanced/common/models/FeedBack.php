<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%feedback}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property string $content 反馈内容
 * @property int $status 状态(0-未处理,1-已处理)
 * @property int $created_at 创建时间
 * @property int $dealed_at 处理时间
 */
class FeedBack extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%feedback}}';
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
            '1' => '已处理',
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
            [['content'], 'required'],
            [['user_id', 'status', 'created_at','dealed_at'], 'integer'],
            [['content'], 'string'],
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
            'content' => '反馈内容',
            'status' => '状态',
            'created_at' => '创建时间',
            'dealed_at' => '处理时间'
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
            if(!$insert && $this->status != '0' && empty($this->dealed_at)) {
                $this-> dealed_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
