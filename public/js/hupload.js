var upload;
var uploadInst;

layui.use('upload', function(){
    upload = layui.upload;
    uploadInst = function(setting){
        upload.render({
            elem: setting.id //绑定元素
            ,url: setting.uploadUrl //上传接口  0
            ,multiple:setting.multiple||false
            ,done: function(res){

                if(res.status){
                    var str ='';
                    str +='<div class="col-sm-3"> ' +
                        '<input type="hidden" value="'+res.url+'" class="form-control" name="'+setting.input_name+'">' +
                        '<img src="'+res.url+'"  style="width: 100%"><a class="btn  btn-primary btn-sm text-center del_btn" style="margin-bottom: 10px;margin-top: 10px;cursor: pointer">删除</a>'+
                        '</div>';
                    if(!setting.multiple){
                        $(setting.img_id).html(str)
                    }else{
                        $(setting.img_id).append(str)
                    }
                }else{
                    layerMsgRed('上传失败');
                    return false;
                }
            }
            ,error: function(){
                //请求异常回调
            },size: 10000
        });
    }
});
