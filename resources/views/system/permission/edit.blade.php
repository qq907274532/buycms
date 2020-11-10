
<link rel="stylesheet" href="{{ asset('admin/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/select2/select2.css') }}">

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">修改权限</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal perm-form" onsubmit="return false;">
        <div class="box-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>父级菜单</label>
                    <div class="col-sm-8">
                        <select class="form-control parent_id" name="parent_id" style="width: 50%">
                            <option value="0">Root</option>
                            {!! $optionHtml !!}
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>类型</label>
                    <div class="col-sm-8">
                        <select name="type" class="form-control">
                            <option value="1" {{ $permission['type'] == 1 ? 'selected' : '' }}>页面</option>
                            <option value="2" {{ $permission['type'] == 2 ? 'selected' : '' }}>菜单</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>标识</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="slug" placeholder="如: permission.create" value="{{ $permission['slug'] }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>名称</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" value="{{ $permission['name'] }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>路由</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="wild_uri" placeholder="支持正则表达式，用于权限验证" value="{{ $permission['wild_uri'] }}">
                    </div>
                </div>

                <div class="form-group menu-option" {{ $permission['type'] == 1 ? 'style=display:none' : '' }}>
                    <label class="col-sm-3 control-label"><span class="red">*</span>菜单链接</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="menu_uri" placeholder="用于左侧菜单跳转" value="{{ $permission['menu_uri'] }}">
                    </div>
                </div>

                <div class="form-group menu-option" {{ $permission['type'] == 1 ? 'style=display:none' : '' }}>
                    <label for="icon" class="col-sm-3 control-label"><span class="red">*</span>图标</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                            <input type="text" id="icon" name="menu_icon" value="{{ $permission['menu_icon'] }}" class="form-control icon" placeholder="输入 图标" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>是否启用</label>
                    <div class="col-sm-9">
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

<script src="{{ asset('admin/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js') }}"></script>
<script>

    $('.icon').iconpicker({placement:'bottomLeft'});
    $('select[name="type"]').change(function() {
        if ($(this).val() == '1') {
            $('.menu-option').hide();
        } else {
            $('.menu-option').show();
        }
    });
</script>
