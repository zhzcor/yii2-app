<?php

namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;

class CCmodel extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    function getStringErrors()
    {
        if(empty($this->getErrors())){
            return "";
        }
        $result = "";
        foreach($this->getErrors() as $field => $v)
        {
            if(is_array($v)){
                $result .= '['.$field.']'.implode(',', $v);
            }elseif(gettype($v) == 'string'){
                $result .= $v;
            }
        }
        return $result;
    }
    
    
    function getArrayErrors()
    {
        if(empty($this->getErrors())){
            return [];
        }
        $result = [];
        foreach($this->getErrors() as $field => $v)
        {
            if(is_array($v)){
                $result[] = [$field=>implode(',', $v)];
            }elseif(gettype($v) == 'string'){
                $result[] = $v;
            }
        }
        return $result;
    }
    
    
    function getFristError()
    {
        if(empty($this->getErrors())){
            return "";
        }
        
        $result = "";
        foreach($this->getErrors() as $field => $v)
        {
            if(is_array($v)){
                $result .= current($v);
            }
            else if(gettype($v) == 'string'){
                $result .= $v;
            }
            return $result;
        }
    }
    
    function getModelErrors()
    {
        if(empty($this->getErrors())){
            return [];
        }
        foreach($this->getErrors() as $field => $v)
        {
            if(is_array($v)){
                $result[$field] = implode(',', $v);
            }elseif(gettype($v) == 'string'){
                $result[$field] = $v;
            }
        }
        return $result;
    }
}
