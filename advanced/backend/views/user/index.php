<?php
use backend\assets\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Url;

// 定义标题和面包屑信息
$this->title = '用户信息';

AdminAsset::addCss($this,'@web/public/assets/css/chosen.css');
AdminAsset::addCss($this,'@web/public/assets/js/lightbox2/css/lightbox.min.css');

AdminAsset::addScript($this,'@web/public/assets/js/chosen.jquery.min.js');
AdminAsset::addScript($this,'@web/public/assets/js/lightbox2/js/lightbox.min.js');
?>

<div class="well">
    <form id="search-form">
        <div class="row">
        	<div class="col-xs-3">
                <div class="form-group">
                    <label class="col-sm-3 control-label">用户ID</label>
                    <div class="col-sm-9">
                        <?=Html::input('text','id','',['class' => 'form-control','placeholder'=>'用户ID']);?>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">手机号</label>
                    <div class="col-sm-9">
                       <?=Html::input('text','telephone','',['class' => 'form-control','placeholder'=>'手机号']);?>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">昵称</label>
                    <div class="col-sm-9">
                       <?=Html::input('text','nickname','',['class' => 'form-control','placeholder'=>'昵称']);?>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">性别</label>
                    <div class="col-sm-9">
                       <?=Html::dropDownList('sex', null, Yii::$app->params['userSex'] , [
                            'class' => 'chosen-select tag-input-style',
                            'data-placeholder' => '性别',
                        ])?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row sep-top">
        	<div class="col-xs-3">
                <div class="form-group">
                    <label class="col-sm-3 control-label">状态</label>
                    <div class="col-sm-9">
                        <?=Html::dropDownList('status', null, Yii::$app->params['userStatus'] , [
                            'class' => 'chosen-select tag-input-style',
                            'data-placeholder' => '状态',
                        ])?>
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
	var baseUrl = '<?=Yii::$app->request->hostInfo;?>/';
	var aSex = <?=\yii\helpers\Json::encode(Yii::$app->params['sex'])?>;
    var aStatus = <?=\yii\helpers\Json::encode($status)?>,
        aStatusColor = <?=\yii\helpers\Json::encode($statusColor)?>;

	var oButtons = {"create":{"bShow":true},
		"deleteAll":{"bShow":false},
		"export":{"bShow":true},
		"updateAll":{"bShow":false}
        },
        oOperationsButtons = {"delete":{"bShow":false},
        				  	  "update":{"bShow":true},
          				  	  "detail": {
          		                   "title": "充值",// a 标签 的title 属性 
          		                   "button-title": "充值", // 按钮显示文字
          		                   "className": "btn-success",// 按钮class 样式 标签
          		                   "cClass":"role-recharge",// 按钮和a 标签共用class 标签
          		                   "icon":"fa-plus-circle", // a 标签 icon 图标
          		               },
        				  	};
      var m = meTables({
            title: "<?=$this->title?>",
            buttons: oButtons,
            operations: {
                "width": "auto",
                buttons: oOperationsButtons
            },
            table: {
                "aoColumns":[
                    {"title": "用户ID", "data": "id", "sName": "id", "edit": {"type": "hidden"}, "defaultOrder": "desc"},
                    {"title": "用户头像", "data": "avatar", "sName": "avatar", "class" : "center",
                    	"createdCell": function (td, data) {
                        	if(data != null){
            					var images = JSON.parse(data);
            					var imageHtml = '<a href="'+baseUrl+images.orig+'" class="pre-image" data-lightbox="image-preview" data-title="用户头像"><img src="'+baseUrl+images.small+'" style="width:60px;"/></a>'
            					$(td).html(imageHtml);
                        	}else{
                        		$(td).html('<img src="'+baseUrl+'public/assets/images/default_avatar.png" style="width:60px;"/>');
                        	}
                        }
                    },
                    {"title": "手机号", "data": "telephone", "sName": "telephone", "edit": {"type": "text", "required":true,"rangelength":"[11, 11]"}, "bSortable": false},
                    {"title": "昵称", "data": "nickname", "sName": "nickname", "edit": {"type": "text", "rangelength":"[2, 50]"}, "bSortable": false},
                    {"title": "性别", "data": "sex", "sName": "sex","value":aSex, "edit": {"type": "select"}, "bSortable": false , 
                    	"createdCell": function (td, data) {
                        	if(data != null){
            					$(td).html(aSex[data]);
                        	}
                        }
                    },
                    {"title": "钱包余额", "data": "money", "sName": "money", "bSortable": false},
                    {"title": "最后交易时间", "data": "costed_at", "sName": "costed_at","bSortable": false, "createdCell" : meTables.dateTimeString},
                    {"title": "密码", "data": "password", "sName": "password", "isHide": true, "edit": {"type": "password", "rangelength":"[2, 20]"}, "bSortable": false, "defaultContent":"", "bViews":false},
                    {"title": "确认密码", "data": "repassword", "sName": "repassword", "isHide": true, "edit": {"type": "password", "rangelength":"[2, 20]", "equalTo":"input[name=password]:first"}, "bSortable": false, "defaultContent":"", "bViews":false},
                    {"title": "状态", "data": "status", "sName": "status", "value": aStatus,
                        "edit": {"type": "radio", "default": 10, "required":true,"number":true},
                        "bSortable": false,
                        "search": {"type": "select"},
                        "createdCell":function(td, data) {
                            $(td).html(mt.valuesString(aStatus, aStatusColor, data));
                        }
                    },
                    {"title": "创建时间", "data": "created_at", "sName": "created_at", "createdCell" : meTables.dateTimeString},
                    {"title": "修改时间", "data": "updated_at", "sName": "updated_at", "createdCell" : mt.dateTimeString},
                ]
            }
        });

    $(function(){
        m.init();
        $select = $(".chosen-select").chosen({
            allow_single_deselect: false,
            width: "100%"
        });

        $(document).on("click", ".role-recharge", function(){
       	     var index = $(this).attr("table-data"),// 这个是获取到表格的第几行
       	        data = m.table.data()[index];// 获取到这一行的数据
       	     if (data) {
        	    	layer.open({
         	   		  type: 2,
         	   		  title: '用户充值',
         	   		  maxmin : true, 
         	   		  shadeClose: true,
         	   		  shade: 0.2,
         	   		  area: ['600px', '300px'],
         	   		  content: '<?=Url::toRoute(['user/recharge'])?>?id='+data.id
         	         }); 
       	     }
       	});
    });
</script>
<?php $this->endBlock(); ?>
