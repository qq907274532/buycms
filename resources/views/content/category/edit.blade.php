<link rel="stylesheet" href="{{ asset('admin/select2/select2.css') }}">
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">编辑分类</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal perm-form" onsubmit="return false;">
        <div class="box-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>父级菜单</label>
                    <div class="col-sm-8">
                        <select class="form-control parent_id" name="parent_id" style="width: 50%">
                            <option value="0">请选择父级</option>
                            {!! $optionHtml !!}
                        </select>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>名称</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" value="{{ $permission['name'] }}" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>关键字</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $permission['keywords'] }}" name="keywords" placeholder="如：test,test">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"> 分类描述：</label>

                    <div class="col-sm-8">
                        <textarea class="form-control" rows="5" name="desc" id="desc" placeholder="分类描述"
                                  required="" aria-required="true">{{ $permission['desc'] }}</textarea>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>是否启用</label>
                    <div class="col-sm-8">
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1" {{ $permission['status'] == 1 ? 'checked' : '' }}> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="2" {{ $permission['status'] == 1 ? '' : 'checked' }}> 否
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script src="{{ asset('admin/select2/select2.full.min.js') }}"></script>
<script>
    $(".parent_id").select2({"allowClear": true, "placeholder": "\u7236\u7ea7\u83dc\u5355"});
</script>
