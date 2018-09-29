$(document).ready(function() {
});

function smnoteinit(obj){
	var element = obj;
	var $summernote = $(element).summernote({
		disableDragAndDrop: true,
		height: 300,
		focus: true,
		lang: 'zh-CN',
		emptyPara: '',
		fontsize: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '30', '36', '48' , '64'],
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'underline', 'clear']],
			['fontname', ['fontname']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['table', ['table']],
			['insert', ['link', 'picture', 'video']],
			['view', ['fullscreen', 'codeview', 'help']]
		],
		//调用图片上传
        callbacks: {
            onImageUpload: function (files) {
                sendFile($summernote, files[0]);
            }
        }
	});
	$(element).summernote('code', $(obj).val());
}


//ajax上传图片
function sendFile($summernote, file) {
    var formData = new FormData();
    formData.append("file", file);
    $.ajax({
        url: "/filemanager/index",
        data: formData,
        dataType : 'JSON',
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            $summernote.summernote('insertImage', data.data.image, function ($image) {
                $image.attr('src', data.data.image);
            });
        }
    });
}