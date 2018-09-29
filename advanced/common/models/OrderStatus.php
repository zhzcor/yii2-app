<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_status}}".
 *
 * @property int $id
 * @property string $name
 */
class OrderStatus extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
    
    
    public static function getStatus($id){
        $status = OrderStatus::findOne($id);
        return $status->name;
    }
}