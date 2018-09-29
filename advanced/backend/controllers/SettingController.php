<?php

namespace backend\controllers;

use Yii;
use common\models\Setting;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseJson;
use common\models\JnbShop;
/**
 * 配置管理
 * @author Administrator
 *
 */
class SettingController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'common\models\Setting';
     
    
    
    /**
     * 设置
     * @return string
     */
    public function actionIndex()
    {  
        $flag = false;
        $request = Yii::$app->request;
        if($request->isPost){
            $postData = $request->post();
            unset($postData['_csrf']);
            if(isset($postData['recommend_shop'])){
                $postData['recommend_shop'] = BaseJson::encode($postData['recommend_shop']);
            }
            Setting::deleteAll();
            foreach ($postData as $key=>$value){
                $setting = new Setting();
                $setting->code  = 'config';
                $setting->key   = $key;
                $setting->value = trim($value);
                $setting->save();
            }
            $flag = true;
        }
        $setting = Setting::find()->all();
        $settingInfo = ArrayHelper::map($setting, 'key', 'value');
        if(isset($settingInfo['recommend_shop'])){
            $commendShop = BaseJson::decode($settingInfo['recommend_shop']);
            $settingInfo['recommend_shop'] = [];
            foreach ($commendShop as $shopid){
                $shopInfo = JnbShop::find()->where(['id'=>$shopid])->select(['id','name'])->one();
                $settingInfo['recommend_shop'][] = ['id'=>$shopInfo->id , 'name'=>"【".$shopInfo->id."】".$shopInfo->name];
            }
        }else{
            $settingInfo['recommend_shop'] = [];
        }
        return $this->render('index' , 
            [
                'setting'=>$settingInfo ,
                'flag' => $flag
            ]
        );
    }
}
