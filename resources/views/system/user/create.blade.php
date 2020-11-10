<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">添加用户</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal admin-form" autocomplete="off" onsubmit="return false;">
        <div class="box-body">
            <div class="row ">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>用户名</label>
                    <div class="col-sm-8">
                        <input type="text" name="username" class="form-control" placeholder="登录名，最少2字符">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>密码</label>
                    <div class="col-sm-8">
                        <input type="password" name="password" class="form-control" placeholder="登录密码，最少6字符" autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>姓名</label>
                    <div class="col-sm-8">
                        <input type="text" name="realname" class="form-control" placeholder="真实姓名">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">电话号码</label>
                    <div class="col-sm-8">
                        <input type="text" name="phone" class="form-control" placeholder="手机号">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-8">
                        <input type="email" name="email" class="form-control" placeholder="有效的邮箱地址">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="red">*</span>角色</label>
                    <div class="col-sm-8">
                        <select class="form-control roles" name="role_ids[]"  data-placeholder="输入 角色" style="width: 50%">
                            @foreach($roles as $role)
                                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


            </div>
        </div>
    </form>
</div>

