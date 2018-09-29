//公用js
$(document).ready(function () {
	
	//layer弹出层
	$(document).on('click', '[role="layer-remote"]', function () {
		var url = $(this).attr('data-url');
        var title = $(this).attr('title') == undefined  ? '查看' : $(this).attr('title');
        var type = $(this).attr('type');
        var width = $(this).attr('width') == undefined ? '42%' : $(this).attr('width');
        var height = $(this).attr('height') == undefined ? '90%' : $(this).attr('height');
    	layer.open({
  		  type: 2,
  		  title: title,
  		  maxmin : true, 
  		  shadeClose: true,
  		  shade: 0.2,
  		  area: [width, height],
  		  content: url //iframe的url
        }); 
    	return false;
    });
	 
});


$(document).on('click' , '.cancel_btn' , function(){
	layer.closeAll();
	parent.layer.closeAll();
});

$(document).on('click' , '.file_save_btn' , function(){
	$('#layer-form').ajaxSubmit({ 
	       type:'post', 
	       dataType:'json', 
	       beforeSend: function () {
	        	layer.load(1, {shade: [0.1,'#fff']});
	        },
	       success:function(response){ 
	    	   if(response.errCode == '0'){
	            	$(window.parent.document.getElementById('show-table-refresh')).trigger('click');
	            	parent.layer.closeAll();
	            }else{
	            	for(i in response.errMsg){
	            		if($(".field-notify-"+i).length >0){
	            			$(".field-notify-"+i).addClass('has-error');
	                		$(".field-notify-"+i).find('.help-block-error').html(response.errMsg[i]);
	            		}else{
	            			$(".field-"+i).addClass('has-error');
	                		$(".field-"+i).find('.help-block-error').html(response.errMsg[i]);
	            		}
	            	}
	            }
	       }, 
	       error:function(){ 
	    	   layer.msg('系统错误');
	       } ,
	       complete:function(){
	    	   layer.closeAll('loading');
		   }
     }); 
});


$(document).on('click' , '.save_btn' , function(){
	var url = $("#layer-form").attr('action');
	var data = $("#layer-form").serializeArray();
	$.ajax({
        url: url,
        method: 'post',
        data: data,
        dataType:'json',
        async: false,
        beforeSend: function () {
        	layer.load(1, {shade: [0.1,'#fff']});
        },
        error: function (response) {
        	layer.msg('系统错误');
        },
        success: function (response) {
            if(response.errCode == '0'){
            	$(window.parent.document.getElementById('show-table-refresh')).trigger('click');
            	parent.layer.closeAll();
            }else{
            	for(i in response.errMsg){
            		if($(".field-notify-"+i).length >0){
            			$(".field-notify-"+i).addClass('has-error');
                		$(".field-notify-"+i).find('.help-block-error').html(response.errMsg[i]);
            		}else{
            			$(".field-"+i).addClass('has-error');
                		$(".field-"+i).find('.help-block-error').html(response.errMsg[i]);
            		}
            	}
            }
        },
        complete:function(){
	    	layer.closeAll('loading');
	    }
    });
});

function showloading(){
	layer.load(1, {
		  shade: [0.2,'#000'] //0.1透明度的白色背景
	});
}

//iframe提交回调
function callback(code , message){
	if(code == '1'){
		layer.alert(message, {icon: 1} , function(){
			layer.closeAll();
			//window.location.reload();
		});
	}else{
		layer.alert(message, {icon: 2});
	}
}

//加载中
function showloading(){
	layer.load(1, {
		  shade: [0.2,'#000'] //0.1透明度的白色背景
	});
}


function close_loading(){
	layer.closeAll('loading');
}


//建立一個可存取到該file的url  
function getObjectURL(file) {  
  var url = null ;   
  // 下面函数执行的效果是一样的，只是需要针对不同的浏览器执行不同的 js 函数而已  
  if (window.createObjectURL!=undefined) { // basic  
    url = window.createObjectURL(file) ;  
  } else if (window.URL!=undefined) { // mozilla(firefox)  
    url = window.URL.createObjectURL(file) ;  
  } else if (window.webkitURL!=undefined) { // webkit or chrome  
    url = window.webkitURL.createObjectURL(file) ;  
  }  
  return url ;  
}  