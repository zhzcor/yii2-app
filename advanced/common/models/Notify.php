<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%notify}}".
 *
 * @property int $id 主键ID
 * @property int $user_id 用户ID
 * @property string $type_code 通知类型
 * @property string $title 标题
 * @property string $content 内容
 * @property string $html_content 链接内容
 * @property int $is_read 是否已读
 * @property int $created_at 发布时间
 * @property int $order_id 订单ID
 */
class Notify extends CCmodel
{
    
    public $user_group;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notify}}';
    }
    
    
    /**
     * getArrayStatus() 获取状态说明信息
     * @param integer|null $intStatus
     * @return array|string
     */
    public static function getArrayStatus($intStatus = null)
    {
        $array = [
            '0' => '未读',
            '1' => '已读',
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
    public function rules()
    {
        return [
            [['type_code', 'title', 'content'], 'required'],
            [['user_id', 'is_read', 'created_at','order_id'], 'integer'],
            [['content','html_content'], 'string'],
            [['type_code'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 250],
        ];
    }
    
    
    /**
     * 添加通知
     * @param unknown $user_id
     * @param unknown $type_code
     * @param unknown $title
     * @param unknown $content
     */
    public static function add($user_id , $type_code , $title , $content , $order_id = 0){
        $notify = new Notify();
        $notify->user_id = $user_id;
        $notify->type_code = $type_code;
        $notify->title = $title;
        $notify->content = $content;
        $notify->is_read = 0;
        $notify->order_id = $order_id;
        $notify->save();
        return $notify->id;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'type_code' => '类型',
            'title' => '标题',
            'content' => '内容',
            'html_content' => '链接内容',
            'is_read' => '是否已读',
            'order_id' => '订单ID',
            'created_at' => '发布时间',
        ];
    }
    
    
}
