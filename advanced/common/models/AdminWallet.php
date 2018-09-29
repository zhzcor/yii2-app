<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admin_wallet}}".
 *
 * @property int $id 主键ID
 * @property int $admin_id 管理员ID
 * @property string $money 余额
 * @property int $updated_at 最后更新时间
 */
class AdminWallet extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_wallet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_id', 'updated_at'], 'required'],
            [['admin_id', 'updated_at'], 'integer'],
            [['money'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => '管理员',
            'money' => '余额',
            'updated_at' => '更新时间',
        ];
    }
}
