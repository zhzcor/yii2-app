<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_account}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property string $type 账号类型
 * @property string $fullname 姓名
 * @property string $acc_number 账号
 * @property string $openid 微信openid
 * @property int $created_at 创建时间
 */
class UserAccount extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_account}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'fullname', 'acc_number'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['type'], 'string'],
            [['fullname', 'acc_number','openid'], 'string', 'max' => 50],
            ['type' , 'validateType'],
            ['acc_number' , 'validateAccNumber']
        ];
    }

    
    /**
     * 效验类型
     */
    public function validateType($attribute, $params){
        if(!array_key_exists($this->type, Yii::$app->params['account_type'])){
            $this->addError($attribute, '账户类型不支持');
        }
    }
    
    
    /**
     * 效验账号
     */
    public function validateAccNumber($attribute, $params){
        if(!$this->id){
            $account = $this->findOne(['type'=>$this->type , 'acc_number'=>$this->acc_number]);
            if(!empty($account)){
                $this->addError($attribute, '账号已绑定');
            }
        }else{
            $account = $this->find()->where(['type'=>$this->type , 'acc_number'=>$this->acc_number])->andWhere(['<>' , 'id' , $this->id])->one();
            if(!empty($account)){
                $this->addError($attribute, '账号已绑定');
            }
        }
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键ID',
            'user_id' => '用户ID',
            'type' => '账号类型',
            'fullname' => '姓名',
            'acc_number' => '账号',
            'openid' => '微信openid',
            'created_at' => '创建时间',
        ];
    }
}
