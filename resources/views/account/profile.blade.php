@extends('layouts.app')
@section('title', '个人信息')
@section('header', '个人')
@section('header.description', '信息')

@section('content')
	<div class="">
		<div class="box-header with-border">
			<h3 class="box-title"></h3>
			<div class="box-tools">
			</div>
		</div>

		<form class="form-horizontal admin-form" autocomplete="off">
			<div class="box-body">
				<div class="row col-sm-6">
					<div class="form-group">
						<label class="col-sm-3 control-label"><span class="red">*</span>姓名</label>
						<div class="col-sm-9">
							<input type="text" name="realname" class="form-control" placeholder="真实姓名" value="{{ $user['realname'] }}" disabled>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">用户名</label>
						<div class="col-sm-9">
							<input type="text" name="username" class="form-control" placeholder="登录名，最少2字符" value="{{ $user['username'] }}" disabled>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">密码</label>
						<div class="col-sm-9">
							<input type="password" name="password" class="form-control" placeholder="不修改请留空，最少6字符" autocomplete="new-password">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">电话号码</label>
						<div class="col-sm-9">
							<input type="text" name="phone" class="form-control" placeholder="手机号" value="{{ $user['phone'] }}">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">邮箱</label>
						<div class="col-sm-9">
							<input type="email" name="email" class="form-control" placeholder="有效的邮箱地址" value="{{ $user['email'] }}">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label"></label>
						<div class="col-sm-offset-3">
							<button type="submit" class="btn btn-default save">保存</button>
						</div>
					</div>

				</div>
			</div>
		</form>

	</div>
@endsection

@section('js')
	<script>
        $('.save').click(function() {
            ajaxPostForm($(this), "{{ url('account/profile') }}");
        });
	</script>
@endsection
