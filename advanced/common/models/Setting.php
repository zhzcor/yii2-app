<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property int $id
 * @property string $code
 * @property string $key
 * @property string $value
 */
class Setting extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'key', 'value'], 'required'],
            [['value'], 'string'],
            [['code', 'key'], 'string', 'max' => 128],
        ];
    }

    /**
     * 获取配置值
     * @param unknown $key
     */
    public static function _get($key){
        $setting = Setting::find()->all();
        $settingInfo = ArrayHelper::map($setting, 'key', 'value');
        return isset($settingInfo[$key]) ? $settingInfo[$key] : '';
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => '代码',
            'key' => '键',
            'value' => '值',
        ];
    }
}
