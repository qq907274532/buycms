
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">添加轮播图</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal role-form" onsubmit="return false;">
        <div class="box-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>标题：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="title" placeholder="标题">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>url：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="url" placeholder="含有http的地址：比如 https://www.baidu.com/">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>排序：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sort" placeholder=""  value="999">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>图片：</label>
                    <div class="col-sm-9" id="uploader-demo">
                        <!--用来存放item-->
                        <div id="thelist" class="uploader-list row"></div>
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
