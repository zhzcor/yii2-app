<?php
namespace common\models;

use Yii;
use yii\base\Model;

class BaseModel extends Model
{    
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
            }
            else if(gettype($v) == 'string'){
                $result .= $v;
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
            }
            else if(gettype($v) == 'string'){
                $result[] = $v;
            }
        }
        return $result;
    }
    
    
    public static function getLabels($value){
        return Yii::$app->params[$value];
    }

    //返回处理信息结果
    public function _returnMessage($code , $message = '' , $errors = '' , $logname = ''){
        if($code == '0000'){
            $result = [
                'code' => $code,
                'message'=>$message!= '' ? $message : '处理成功' ,
            ];
            if($logname){
                Yii::info('return:'.BaseJson::encode($result).PHP_EOL , $logname);
            }
            return $result;
        }else{
            $result = [
                'code' => $code,
                'message'=>$message!= '' ? $message : '处理失败' ,
                'errors' => $errors
            ];
            if($logname){
                Yii::info('return:'.BaseJson::encode($result).PHP_EOL , $logname);
            }
            return $result;
        }
    }



}