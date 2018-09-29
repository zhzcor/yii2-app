<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%wallet}}".
 *
 * @property int $id 主键ID
 * @property string $user_id 用户ID
 * @property string $money 余额
 * @property int $updated_at 最后更新时间
 */
class Wallet extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wallet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['money','user_id'], 'number'],
            [['updated_at'], 'integer'],
            ['money' , 'validateMoney']
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
            'money' => '余额',
            'updated_at' => '最后更新时间',
        ];
    }
    
    
    /**
     * 效验余额
     */
    public function validateMoney($attribute, $params){
        if($this->money < 0){
            $this->addError($attribute, '余额不足');
        }
    }
    
    /**
     * 余额交易变化
     * @param unknown $money
     * @param unknown $event
     * @param unknown $carrier
     */
    public static function change($money , $userId = ''){
        try {
            $walletInfo = Wallet::findOne(['user_id'=>$userId ? $userId : Yii::$app->user->id]);
            $walletInfo->money = $walletInfo->money + $money;
            if($walletInfo->save()){
                return $walletInfo->id;
            }else{
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
