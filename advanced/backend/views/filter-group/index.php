<?php
// 定义标题和面包屑信息
$this->title = '筛选项组';
?>
<?=\backend\widgets\MeTable::widget()?>
<?php $this->beginBlock('javascript') ?>
<script type="text/javascript">
    var m = meTables({
        title: "筛选项组",
        table: {
            "aoColumns": [
                			{"title": "主键ID", "data": "id", "sName": "id", "edit": {"type": "hidden", "required": true,"number": true}, "bSortable": false}, 
			{"title": "筛选组名称", "data": "name", "sName": "name", "edit": {"type": "text", "required": true,"rangelength": "[2, 200]"}, "bSortable": false}, 
			{"title": "排序", "data": "sort", "sName": "sort", "edit": {"type": "text", "required": true,"number": true}, "bSortable": false}, 
			{"title": "创建时间", "data": "created_at", "sName": "created_at", "bSortable": false, "createdCell" : meTables.dateTimeString}, 

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