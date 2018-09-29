<?php
use yii\helpers\Html;

// 定义标题和面包屑信息
$this->title = '热搜管理';
?>

<div class="well">
    <form id="search-form">
        <div class="row">
            <div class="col-xs-3">
                <div class="form-group">
                    <label class="col-sm-3 control-label">标题</label>
                    <div class="col-sm-9">
                        <?=Html::input('text','title','',['class' => 'form-control','placeholder'=>'标题']);?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 pull-right" style="margin-top: 10px;">
                <div class="pull-right" id="me-table-buttons">
                    <button class="btn btn-info btn-sm">
                        <i class="ace-icon fa fa-search"></i> 搜索
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<?=\backend\widgets\MeTable::widget()?>
<?php $this->beginBlock('javascript') ?>
<script type="text/javascript">
    var oButtons = {"create":{"bShow":true},
    		"deleteAll":{"bShow":true},
    		"export":{"bShow":true},
    		"updateAll":{"bShow":false}},
    oOperationsButtons = {"see":{"bShow":false},
    	    			"delete":{"bShow":true},
    				  	"update":{"bShow":true}};
    var m = meTables({
        title: "热搜管理",
        buttons: oButtons,
        operations: {
            "width": "auto",
            buttons: oOperationsButtons
        },
        table: {
            "aoColumns": [
                			{"title": "主键", "data": "id", "sName": "id", "edit": {"type": "hidden", "required": true,"number": true}, "bSortable": false}, 
			{"title": "热搜名称", "data": "title", "sName": "title", "edit": {"type": "text", "required": true,"rangelength": "[2, 200]"}, "bSortable": false}, 
			{"title": "排序", "data": "sort", "sName": "sort", "edit": {"type": "text", "number": true}}, 

            ]       
        }
    });
    
    /**
    meTables.fn.extend({
        // 显示的前置和后置操作
        beforeShow: function(data, child) {
            return true;
        },
        afterShow: function(data, child) {
            return true;
        },
        
        // 编辑的前置和后置操作
        beforeSave: function(data, child) {
            return true;
        },
        afterSave: function(data, child) {
            return true;
        }
    });
    */

     $(function(){
         m.init();
     });
</script>
<?php $this->endBlock(); ?>