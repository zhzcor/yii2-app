<?php

namespace common\behaviors;

use yii\base\InvalidCallException;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;

class TimestampBehavior extends AttributeBehavior
{
    /**
     * 定义创建时间的字段名
     * @var string
     */
    public $createdAtAttribute = ['created_at' , 'updated_at'];

    /**
     * 定义修改时间字段名
     * @var string
     */
    public $updatedAtAttribute = ['updated_at'];

    /**
     * 定义值
     * @var integer
     */
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => array_unique(array_merge($this->createdAtAttribute, $this->updatedAtAttribute)),
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedAtAttribute,
            ];
        }
    }
    
    
    public function evaluateAttributes($event)
    {
        if (!empty($this->attributes[$event->name])) {
            //删掉不存在的字段
            $this->attributes[$event->name] = array_intersect($this->owner->attributes(), $this->attributes[$event->name]);
        }
        parent::evaluateAttributes($event);
    }
    

    /**
     * @inheritdoc
     *
     * In case, when the [[value]] is `null`, the result of the PHP function [time()](http://php.net/manual/en/function.time.php)
     * will be used as value.
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            return time();
        }

        return parent::getValue($event);
    }

    /**
     * Updates a timestamp attribute to the current timestamp.
     *
     * ```php
     * $model->touch('lastVisit');
     * ```
     * @param string $attribute the name of the attribute to update.
     * @throws InvalidCallException if owner is a new record (since version 2.0.6).
     */
    public function touch($attribute)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        if ($owner->getIsNewRecord()) {
            throw new InvalidCallException('Updating the timestamp is not possible on a new record.');
        }
        $owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }
}
