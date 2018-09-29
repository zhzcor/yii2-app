<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%brokerage}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property int $recomed_user_id 推荐用户ID
 * @property int $order_id 订单ID
 * @property string $money 获取佣金
 * @property int $created_at 创建时间
 */
class Brokerage extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%brokerage}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'recomed_user_id'], 'required'],
            [['user_id', 'recomed_user_id', 'created_at','order_id'], 'integer'],
            [['money'], 'number'],
        ];
    }
    
    /**
     * 添加佣金记录
     */
    public static function add($user_id , $order_id ,$money){
        $brokerage = new Brokerage();
        $brokerage->user_id = $user_id;
        $brokerage->recomed_user_id = Yii::$app->user->id;
        $brokerage->order_id = $order_id;
        $brokerage->money = $money;
        $brokerage->save();
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'user_id' => '用户',
            'recomed_user_id' => '推荐用户',
            'order_id' => '订单ID',
            'money' => '获得佣金',
            'created_at' => '创建时间',
        ];
    }
}
