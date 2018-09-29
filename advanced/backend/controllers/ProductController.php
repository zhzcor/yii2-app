<?php

namespace backend\controllers;

use Yii;
use common\helpers\ImageProcess;
use yii\web\UploadedFile;
use common\models\JnbProduct;
use yii\helpers\BaseJson;
use common\models\ProductImage;
use common\models\JnbProductImage;
use common\models\Setting;
use common\models\JnbShop;
use yii\helpers\ArrayHelper;
use common\models\JnbCategory;
use common\models\JnbProductCategory;

/**
 * Class ProductController 产品管理 执行操作控制器
 * @package backend\controllers
 */
class ProductController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $modelClass = 'common\models\JnbProduct';
     
    /**
     * 查询处理
     * @param  array $params
     * @return array 返回数组
     */
    public function where($params)
    {
        return [
            'name'=>function($value){
                return ['like', 'p.name', $value];
            },
            'shop'=>function($value){
                return ['like', 's.name', $value];
            },
            'status'=>function($value){
                return ['p.status'=>$value];
            },
            'created_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'p.created_at', strtotime($times[0]) , strtotime($times[1])];
            },
            'updated_at' => function ($value) {
                $times = explode(' To ', $value);
                return ['between', 'p.updated_at', strtotime($times[0]) , strtotime($times[1])];
            },
            'min-list_price'=> function($value){
                return ['>=', 'p.list_price', $value];
            },
            'max-list_price'=> function($value){
                return ['<', 'p.list_price', $value];
            },
            'min-price'=> function($value){
                return ['>=', 'p.price', $value];
            },
            'max-price'=> function($value){
                return ['<', 'p.price', $value];
            },
            'min-sold'=> function($value){
                return ['>=', 'p.sold', $value];
            },
            'max-sold'=> function($value){
                return ['<', 'p.sold', $value];
            },
        ];
    }
    
    
    /**
     * 显示视图
     * @return string
     */
    public function actionIndex()
    {
        // 载入视图
        return $this->render('index', [
            'status' => JnbProduct::getArrayStatus(),    // 状态
            'statusColor' => JnbProduct::getStatusColor(), // 状态对应颜色
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
        $query = $model::find()->from('hc_jnb_product p')->innerJoin('hc_jnb_shop s' , 'p.shop_id=s.id')
        ->select(['p.id','p.name','s.name AS shop_id','p.image','p.description','p.price','p.list_price','p.price_unit','p.sort','p.status','p.protection','p.sold','p.created_at','p.updated_at',"(SELECT GROUP_CONCAT(image order by sort ASC SEPARATOR '-') FROM hc_jnb_product_image WHERE product_id=p.id group by product_id) as images"])
        ->where($where);
        if(Yii::$app->user->identity->role == 'merchant'){
            $query->andWhere(['s.admin_id'=>Yii::$app->user->id]);
        }
        return $query->asArray();
    }
    
    
    public function actionPublish($id = 0){
        $model = new $this->modelClass();
        if($id){
            $model = $model->findOne($id);
        }
        $request = Yii::$app->request;
        if($request->isAjax){
            $postData = $request->post();
            $imagefile = UploadedFile::getInstanceByName('JnbProduct[image]');
            $imageProcess = new ImageProcess();
            if($imagefile){
                $images = $imageProcess->thumb($imagefile , 'product');
                $postData['JnbProduct']['image'] =  BaseJson::encode($images);
            }else{
                unset($postData['JnbProduct']['image']);
            }
            $model->load($postData);
            $model->sort = intval($model->sort);
            if ($model->save()) {
                //产品分类
                JnbProductCategory::deleteAll(['product_id'=>$model->id]);
                foreach ($postData['JnbProduct']['categories'] as $categoryid){
                    $categoryObj = new JnbProductCategory();
                    $categoryObj->product_id = $model->id;
                    $categoryObj->category_id = $categoryid;
                    $categoryObj->save();
                }
                //产品图片
                JnbProductImage::deleteAll("product_id='".$model->id."'");
                if($postData['upload']){
                    $prodImages = explode(',', $postData['upload']);
                    foreach ($prodImages as $key=>$prodImage){
                        //裁剪图片
                        $prodImgs = $imageProcess->indeThumb(str_replace(Yii::$app->request->hostInfo.'/', '', $prodImage));
                        $imageObj = new JnbProductImage();
                        $imageObj->product_id = $model->id;
                        $imageObj->image  = BaseJson::encode($prodImgs);
                        $imageObj->sort   = $key+1;
                        $imageObj->save();
                    }
                }
                return $this->success($model , '发布成功');
            }else{
                return $this->error(1001, $model->getModelErrors());
            }
        }
        if(!empty($model->id)){
            //分类
            $product_categories = JnbProductCategory::findAll(['product_id'=>$model->id]);
            $model->categories = [];
            foreach ($product_categories as $prodCate){
                $model->categories[] = $prodCate['category_id'];
            }
            //图片
            $mainImages = BaseJson::decode($model->image);
            $model->image = Yii::$app->request->hostInfo.'/'.$mainImages['orig'];
            $prodImages = JnbProductImage::findAll(['product_id'=>$model->id]);
            if($prodImages){
                foreach ($prodImages as $img){
                    $imgArr = BaseJson::decode($img->image);
                    if($model->images == ''){
                        $model->images = Yii::$app->request->hostInfo.'/'.$imgArr['orig'];
                    }else{
                        $model->images .= ','.Yii::$app->request->hostInfo.'/'.$imgArr['orig'];
                    }
                }
            }
        }
        $unitStr = Setting::_get('jnb_price_unit');
        $priceUnits = [''=>'选择价格单位'];
        if(trim($unitStr)){
            $unitArr = explode(',', $unitStr);
            foreach ($unitArr as $unit){
                $priceUnits[$unit] = $unit;
            }
        }
        //$this->admins
        $query = JnbShop::find()->where(['status'=>1]);
        if(Yii::$app->user->identity->role == 'merchant'){
            $query->andWhere(['admin_id'=>Yii::$app->user->id]);
        }
        $shopList = $query->all();
        $shops = ArrayHelper::map($shopList, 'id', 'name');
        $categoryList = JnbCategory::find()->from('hc_jnb_category c')
        ->innerJoin('hc_jnb_category ca' , 'c.parent_id=ca.id')
        ->where(['c.status'=>'1'])->andWhere(['<>' , 'c.parent_id' , 0])
        ->select(['c.id','c.parent_id','c.name','ca.name AS pname'])
        ->orderBy('c.sort ASC')->asArray()->all();
        $categories = [];
        foreach ($categoryList as $category){
            $categories[$category['id']] = $category['pname']." > ".$category['name'];
        }
        return $this->renderAjax('publish' , [
            'model' => $model,
            'priceUnit' => $priceUnits,
            'shops' => $shops,
            'categories' => $categories,
        ]);
    }
}
