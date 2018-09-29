<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sms_mobile}}".
 *
 * @property int $id 主键ID
 * @property string $type 类型
 * @property string $mobile 手机号
 * @property string $verify_code 验证码
 * @property int $sended_at 发送时间
 * @property int $expired_at 过期时间
 */
class SmsMobile extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sms_mobile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobile'], 'required','message'=>'请输入{attribute}'],
            [['verify_code','type'], 'required'],
            [['sended_at', 'expired_at'], 'integer'],
/*            [['mobile'], 'match', 'pattern'=>'/^1[0-9]{10}$/','message'=>'{attribute}手机号格式不正确'],*/
            [['verify_code','type'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'mobile' => '手机号',
            'verify_code' => '验证码',
            'sended_at' => 'Sended At',
            'expired_at' => 'Expired At',
        ];
    }
}
