<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jnb_product}}".
 *
 * @property int $id 主键ID
 * @property string $name 产品名称
 * @property int $shop_id 店铺ID
 * @property string $image 主图
 * @property string $description 描述
 * @property string $price 单价
 * @property string $list_price 原价
 * @property string $price_unit 价格单位
 * @property int $sort 排序
 * @property int $status 状态(0:停用,1:启用)
 * @property string $protection 保障
 * @property int $sold 已售数量
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class JnbProduct extends CCmodel
{
    
    
    public $images;
    public $categories;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jnb_product}}';
    }
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'shop_id','price', 'price_unit', 'image','categories'], 'required'],
            [['shop_id', 'sort', 'status', 'sold', 'created_at', 'updated_at'], 'integer'],
            [['description','image'], 'string'],
            [['price', 'list_price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['price_unit', 'protection'], 'string', 'max' => 100],
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
            '0' => '已下架',
            '1' => '已上架',
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
            'name' => '产品名称',
            'shop_id' => '店铺',
            'image' => '主图',
            'categories' => '分类',
            'description' => '描述',
            'price' => '单价',
            'list_price' => '原价',
            'price_unit' => '价格单位',
            'sort' => '排序',
            'status' => '状态',
            'protection' => '保障',
            'sold' => '已售数量',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
