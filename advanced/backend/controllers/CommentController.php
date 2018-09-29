<?php

namespace backend\controllers;

use Yii;
use common\models\JnbCommentReply;
use common\models\JnbComment;
use backend\models\AdminLog;
use common\helpers\Helper;
use yii\helpers\BaseJson;

/**
 * Class CommentController 评论管理 执行操作控制器
 * @package backend\controllers
 */
class CommentController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'common\models\JnbComment';
     
    /**
     * 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        return [
            'user_id' => function($value){
                return ['like', 'u.telephone', $value];
            },
            'product' => function($value){
                return ['like', 'p.name', $value];
            },
            'content' => function($value){
                return ['like', 'c.content', $value];
            },
            'reply' => function($value){
                return ['like', 'cr.content', $value];
            },
            'rating' => function($value){
                return ['like', 'c.rating', $value];
            },
            'created_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'c.created_at', strtotime($times[0]) , strtotime($times[1])];
            },
            'replied_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'cr.created_at', strtotime($times[0]) , strtotime($times[1])];
            },
        ];
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
        $query = $model::find()->from('hc_jnb_comment c')->leftJoin('hc_jnb_comment_reply cr' , 'c.id=cr.comment_id')->innerJoin('hc_user u','c.user_id=u.id')
        ->innerJoin('hc_jnb_product p' , 'c.product_id=p.id')
        ->innerJoin('hc_jnb_shop s' , 'p.shop_id=s.id')
        ->select(['c.id','u.telephone AS user_id','c.product_id','p.name as product','c.images','c.content','c.rating','c.created_at','cr.content AS reply','cr.created_at AS replied_at'])
        ->where($where);
        if(Yii::$app->user->identity->role == 'merchant'){
            $query->andWhere(['s.admin_id'=>Yii::$app->user->id]);
        }
        return $query->asArray();
    }
    
    
    /**
     * 处理删除数据
     * @return mixed|string
     */
    public function actionDelete()
    {
        // 接收参数判断
        $data = Yii::$app->request->post();
        $model = $this->findOne();
        if (!$model) {
            return $this->returnJson();
        }
        
        // 删除数据成功
        if ($model->delete()) {
            JnbCommentReply::findOne(['comment_id'=>$data[$this->pk]])->delete();
            AdminLog::create(AdminLog::TYPE_DELETE, $data, $this->pk . '=' . $data[$this->pk]);
            return $this->success($model);
        } else {
            return $this->error(1004, Helper::arrayToString($model->getErrors()));
        }
    }
    
    /**
     * 回复评论
     * @param unknown $id
     */
    public function actionReplay($id){
        $comment = JnbComment::findOne($id);
        if(!$model = JnbCommentReply::findOne(['comment_id'=>$id])){
            $model = new JnbCommentReply();
        }
        $request = Yii::$app->request;
        if($request->isAjax){
            $postData = $request->post();
            $model->load($postData);
            $model->comment_id = $id;
            $model->product_id = $comment->product_id;
            if ($model->save()) {
                return $this->success($model , '回复成功');
            }else{
                return $this->error(1001, $model->getModelErrors());
            }
        }
        $comment->images = BaseJson::decode($comment->images);
        return $this->renderAjax('replay' , [
            'model' => $model,
            'comment' => $comment
        ]);
    }
    
    /**
     * 导出数据显示问题(时间问题可以通过Excel自动转换)
     * @return  array
     */
    public function getExportHandleParams()
    {
        $array['created_at'] = $array['updated_at'] = $array['reviewed_at'] = $array['replied_at'] = function ($value) {
            if($value){
                return date('Y-m-d H:i:s', $value);
            }
        };
        return $array;
    }
}
