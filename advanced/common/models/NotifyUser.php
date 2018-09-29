<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%notify_user}}".
 *
 * @property int $notify_id 通知ID
 * @property int $user_id 用户ID
 * @property int $is_read 是否已读
 * @property int $readed_at 已读时间
 */
class NotifyUser extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notify_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notify_id', 'user_id'], 'required'],
            [['notify_id', 'user_id', 'is_read', 'readed_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'notify_id' => 'Notify ID',
            'user_id' => 'User ID',
            'is_read' => 'Is Read',
            'readed_at' => 'Readed At',
        ];
    }
}
