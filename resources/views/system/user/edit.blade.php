<div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">编辑用户</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal admin-form" autocomplete="off" onsubmit="return false;">
            <div class="box-body">
                <div class="row ">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-8">
                            <input type="text" name="username" class="form-control" placeholder="登录名，最少2字符" value="{{ $user['username'] }}" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-8">
                            <input type="password" name="password" class="form-control" placeholder="不修改请留空，最少6字符" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">*</span>姓名</label>
                        <div class="col-sm-8">
                            <input type="text" name="realname" class="form-control" placeholder="真实姓名" value="{{ $user['realname'] }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">电话号码</label>
                        <div class="col-sm-8">
                            <input type="text" name="phone" class="form-control" placeholder="手机号" value="{{ $user['phone'] }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">邮箱</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" class="form-control" placeholder="有效的邮箱地址" value="{{ $user['email'] }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">*</span>角色</label>
                        <div class="col-sm-8">
                            <select class="form-control roles" name="role_ids[]" data-placeholder="输入 角色" style="width: 50%">

                                @foreach($roles as $role)
                                    <option value="{{ $role['id'] }}" {{ in_array($role['id'], Arr::pluck($user['roles'], 'id')) ? 'selected' : ''  }}>{{ $role['name'] }}{{ $role['id'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

