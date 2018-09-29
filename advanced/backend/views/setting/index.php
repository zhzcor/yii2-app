<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// 定义标题和面包屑信息
$this->title = '系统设置';

?>

<?php $form = ActiveForm::begin(['method'=>'post' ,'id' => 'layer-form' , 'options'=>['class'=>'form-horizontal']]); ?>
<H4>帮我送配置</H4>
<fieldset>
 <div class="tab-content">
    <div class="form-group">
    	<label class="col-sm-3 control-label">平台手续费比例</label>
        <div class="col-sm-3 input-group"><?=Html::input('number' , 'fees_percent' , isset($setting['fees_percent']) ? $setting['fees_percent'] : '' , ['id'=>'fees_percent' , "class"=>"form-control" , "maxlength"=>"3"])?><span class="input-group-addon">%</span></div>
    </div>
     <div class="form-group">
    	<label class="col-sm-3 control-label">邀请奖励金比例</label>
        <div class="col-sm-3 input-group"><?=Html::input('number' , 'reward_percent' , isset($setting['reward_percent']) ? $setting['reward_percent'] : '' , ['id'=>'reward_percent' , "class"=>"form-control" , "maxlength"=>"3"])?><span class="input-group-addon">%</span></div>
    </div>
    <div class="form-group">
    	<label class="col-sm-3 control-label">推送范围</label>
        <div class="col-sm-3 input-group"><?=Html::input('number' , 'push_range' , isset($setting['push_range']) ? $setting['push_range'] : '' , ['id'=>'push_range' , "class"=>"form-control" , "maxlength"=>"3"])?><span class="input-group-addon">公里范围内</span></div>
    </div>
</div>
</fieldset>
<H4>技能帮配置</H4>
<fieldset>
 <div class="tab-content">
    <div class="form-group">
    	<label class="col-sm-3 control-label">价格单位(英文逗号隔开)</label>
        <div class="col-sm-3 input-group"><?=Html::textarea('jnb_price_unit' , isset($setting['jnb_price_unit']) ? $setting['jnb_price_unit'] : '' , ['id'=>'jnb_price_unit' , "class"=>"form-control" , "style"=>"height:120px;"])?></div>
    </div>
</div>
</fieldset>
<fieldset style="margin-top: 10px;">
    <div class="form-group">
    	<label class="col-sm-3 control-label"></label>
        <?=Html::submitButton("保存" , ['id'=>'settingSave' , "class"=>"btn btn-success"])?>
    </div>
</fieldset>
<?php ActiveForm::end(); ?>
<?php $this->beginBlock('javascript') ?>
<script type="text/javascript">
var flag = '<?=$flag?>';
if(flag){
	layer.msg('保存成功！');
}
</script>
<?php $this->endBlock(); ?>