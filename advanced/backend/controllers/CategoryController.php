<?php

namespace backend\controllers;

use Yii;
use common\helpers\ImageProcess;
use yii\web\UploadedFile;
use yii\helpers\BaseJson;
use common\models\JnbCategory;
use yii\helpers\ArrayHelper;

/**
 * Class CategoryController 分类与服务 执行操作控制器
 * @package backend\controllers
 */
class CategoryController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'common\models\JnbCategory';
     
    /**
     * 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        return [
            'name' => function($value){
                return ['like', 'c.name', $value];
            },
            'status' => function($value){
                return ['c.status'=>$value];
            },
            'parent_id' => function($value){
                return ['c.parent_id'=>$value];
            },
            'remark' => function($value){
                return ['like', 'c.remark', $value];
            },
            'created_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'c.created_at', strtotime($times[0]) , strtotime($times[1])];
            },
        ];
    }
    
    
    /**
     * 显示视图
     * @return string
     */
    public function actionIndex()
    {
        $parentList = JnbCategory::find()->where(['parent_id'=>0])->select(['id','name'])->asArray()->all();
        array_unshift($parentList, ['id'=>'' , 'name'=>'请选择']);
        $categories = ArrayHelper::map($parentList, 'id', 'name');
        // 载入视图
        return $this->render('index', [
            'status' => JnbCategory::getArrayStatus(),    // 状态
            'statusColor' => JnbCategory::getStatusColor(), // 状态对应颜色
            'categories' => $categories
        ]);
    }
    
    
    /**
     * 获取查询对象(查询结果一定要为数组)
     *
     * @param mixed|array $where 查询条件
     * @return \yii\db\ActiveQuery 返回查询对象
     * @see actionSearch()
     * @see actionExport()
     */
    protected function getQuery($where)
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = $this->modelClass;
        return $model::find()->from('hc_jnb_category c')->leftJoin('hc_jnb_category cc' , 'c.parent_id=cc.id')
        ->select(['c.id','c.name','c.icon','c.sort','c.status','cc.name AS parent_id','c.remark','c.created_at','c.updated_at'])->where($where)->asArray();
    }
    
    
    public function actionModify($id = 0){
        $model = new $this->modelClass();
        if($id){
            $model = $model->findOne($id);
        }
        $request = Yii::$app->request;
        if($request->isAjax){
            $postData = $request->post();
            $imageProcess = new ImageProcess();
            //身份证正面
            $cardFace = UploadedFile::getInstanceByName('JnbCategory[icon]');
            if($cardFace){
                $imagesFace = $imageProcess->thumb($cardFace , 'category');
                $postData['JnbCategory']['icon'] = BaseJson::encode($imagesFace);
            }else{
                unset($postData['JnbCategory']['icon']);
            }
            $model->load($postData);
            $model->parent_id = intval($model->parent_id);
            $model->sort = intval($model->sort);
            if ($model->save()) {
                return $this->success($model , '发布成功');
            }else{
                return $this->error(1001, $model->getModelErrors());
            }
        }
        
        if($model->status == '' && $model->status !== 0){
            $model->status = 1;
        }
        if($model->icon){
            $images = BaseJson::decode($model->icon);
            $model->icon = Yii::$app->request->hostInfo.'/'.$images['orig'];
        }
        if($model->parent_id || $model->parent_id == ''){
            $parentList = JnbCategory::find()->where(['parent_id'=>0])->select(['id','name'])->asArray()->all();
        }else{
            $parentList = [];
        }
        array_unshift($parentList, ['id'=>'' , 'name'=>'请选择']);
        $categories = ArrayHelper::map($parentList, 'id', 'name');
        return $this->renderAjax('modify' , [
            'model' => $model,
            'categories' => $categories
        ]);
    }
}
