<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">编辑角色</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal role-form" onsubmit="return false;">
        <div class="box-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="red">*</span>角色名称</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" value="{{ $role['name'] }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">角色描述</label>
                    <div class="col-sm-9">
                        <textarea name="description" class="form-control" rows=3>{{ $role['description'] }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

