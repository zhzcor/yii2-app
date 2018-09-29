<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_category}}".
 *
 * @property int $id 主键ID
 * @property string $name 分类名称
 * @property string $icon 分类图标
 * @property int $sort 排序
 * @property int $status 状态(0:停用,1:启用)
 * @property int $parent_id 父分类ID
 * @property string $remark 分类备注
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class JnbCategory extends CCmodel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','status'], 'required'],
            [['sort', 'status', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['remark'], 'string'],
            [['name'], 'string', 'max' => 200],
            [['icon'], 'string', 'max' => 500],
        ];
    }
    
    /**
     * getArrayStatus() 获取状态说明信息
     * @param integer|null $intStatus
     * @return array|string
     */
    public static function getArrayStatus($intStatus = null)
    {
        $array = [
            '0' => '禁用',
            '1' => '启用',
        ];
        
        if ($intStatus !== null && isset($array[$intStatus])) {
            $array = $array[$intStatus];
        }
        
        return $array;
    }
    
    /**
     * getStatusColor() 获取状态值对应颜色信息
     * @param null $intStatus
     * @return array|mixed
     */
    public static function getStatusColor($intStatus = null)
    {
        $array = [
            '1' => 'label-success',
            '0' => 'label-warning',
        ];
        
        if ($intStatus !== null && isset($array[$intStatus])) {
            $array = $array[$intStatus];
        }
        
        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'icon' => '分类图标',
            'sort' => '排序',
            'status' => '状态',
            'parent_id' => '父分类',
            'remark' => '备注',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
