<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_history_search}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property string $title 名称
 * @property int $created_at 创建时间
 */
class JnbHistorySearch extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_history_search}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','user_id'], 'required'],
            [['created_at','user_id'], 'integer'],
            [['title'], 'string', 'max' => 100],
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
            'title' => '名称',
            'created_at' => '创建时间',
        ];
    }
}
