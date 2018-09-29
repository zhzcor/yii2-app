<?php

namespace backend\controllers;

use Yii;
use yii\web\UploadedFile;
use common\helpers\ImageProcess;
use yii\helpers\BaseJson;
/**
 * Class ContentController 内容管理 执行操作控制器
 * @package backend\controllers
 */
class ContentController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'common\models\Content';
     
    /**
     * 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        return [
            
        ];
    }
    
    
    public function actionModify($id = 0){
        $model = new $this->modelClass();
        if($id){
            $model = $model->findOne($id);
        }
        $request = Yii::$app->request;
        if($request->isAjax){
            $postData = $request->post();
            $imagefile = UploadedFile::getInstanceByName('Content[image]');
            if($imagefile){
                $imageProcess = new ImageProcess();
                $images = $imageProcess->orig($imagefile , 'content');
                $postData['Content']['image'] = $images;
            }else{
                unset($postData['Content']['image']);
            }
            $model->attributes = $postData['Content'];
            if(isset($postData['ctitle'])){
                $content = [];
                foreach ($postData['ctitle'] as $key=>$title){
                    if(trim($title) && trim($postData['ccontent'][$key])){
                        $content[] = ['title'=>trim($title) , 'content'=>trim($postData['ccontent'][$key])];
                    }
                }
                $model->content = BaseJson::encode($content);
            }
            if($model->save()){
                return $this->success($model , '操作成功');
            }else{
                return $this->error(1001, $model->getErrors());
            }
        }
        if($model->title == '帮助中心'){
            $model->content = BaseJson::decode($model->content);
        }
        if($model->image){
            $model->image = Yii::$app->request->hostInfo.'/'.$model->image;
        }
        return $this->renderAjax('modify' , [
            'model' => $model,
        ]);
    }
}
