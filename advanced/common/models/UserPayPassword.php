<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_pay_password}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户id
 * @property string $password 支付密码（加密）
 * @property int $created_at 验证时间
 */
class UserPayPassword extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_pay_password}}';
    }

}
