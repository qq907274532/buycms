
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">修改轮播图</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal role-form" onsubmit="return false;">
        <div class="box-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>标题：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="title" placeholder="标题" value="{{$info['title']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>url：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="url" placeholder="含有http的地址：比如 https://www.baidu.com/" value="{{$info['url']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>排序：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sort" placeholder=""  value="{{$info['sort']}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>图片：</label>
                    <div class="col-sm-9" id="uploader-demo">
                        <!--用来存放item-->
                        <div id="thelist" class="uploader-list row">
                            <div class="col-sm-3">
                                <input type="hidden" value="{{$info['img']}}" class="form-control" name="img">
                                <img src="{{$info['img']}}"  style="width: 100%"><a class="btn  btn-primary btn-sm text-center del_btn" style="margin-bottom: 10px;margin-top: 10px;cursor: pointer">删除</a>
                            </div>
                        </div>
                        <div >
                            <button type="button" class="layui-btn" id="test1">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </form>
</div>

<script src="{{ asset('js/hupload.js') }}?v={{ \App\Services\HelperService::random_number(9)}}"></script>
<script>
    $(function () {
        uploadInst({
            id:"#test1",
            uploadUrl:"{{url('/upload_img')}}" ,
            input_name:'img',
            multiple:false,
            img_id :"#thelist"
        });
    })

</script>
