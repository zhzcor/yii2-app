<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\assets\AppAsset;
use backend\assets\AdminAsset;
use yii\helpers\Json;


/* @var $this yii\web\View */
/* @var $model app\models\CboiDelivery */

AdminAsset::register($this);
AppAsset::register($this);

AdminAsset::addCss($this,'@web/public/assets/css/chosen.css');
AdminAsset::addScript($this,'@web/public/assets/js/chosen.jquery.min.js');


AdminAsset::addScript($this,'@web/public/assets/js/jquery.form.js');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?=Yii::$app->name.Html::encode($this->title) ?></title>
    <meta name="description" content="3 styles with inline editable feature" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <?= Html::csrfMetaTags() ?>
    <?php $this->head(); ?>
    <link rel="stylesheet" href="/public/assets/css/ace.min.css" id="main-ace-style" />
    <script src="/public/assets/js/ace-extra.min.js"></script>

</head>
<body class="no-skin" style="background: #fff">
<?php $this->beginBody() ?>
<div class="layer-dialog">
    <div class="modal-content">   
        <div class="modal-body">
            <?php $form = ActiveForm::begin(['method'=>'post' ,'id' => 'layer-form' , 'options'=>['class'=>'form-horizontal']]); ?>
            <fieldset>
            	<div class="form-group" style="margin-bottom: 50px;">
                	<label class="col-sm-3 control-label">用户</label>
                    <div class="col-sm-7">
						<input class="form-control" value="<?=$user->telephone;?>" disabled="true" type="text"/>
                    </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">充值金额</label>
                    <div class="col-sm-7">
                    	<input class="form-control" name="money" value="" type="text"/>
                    </div>
                </div>
            </fieldset>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="modal-footer">
         	<button type="button" class="btn btn-default cancel_btn">取消</button>
        	<button type="button" class="btn btn-primary file_save_btn">确定</button>
        </div>
    </div>
</div>
<!-- 公共的JS文件 -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='/public/assets/js/jquery.min.js'>"+"<"+"/script>");
</script>
<script src="/public/assets/js/bootstrap.min.js"></script>
<?php $this->endBody() ?>
<script type="text/javascript">

</script>
</body>
</html>
<?php $this->endPage() ?>
