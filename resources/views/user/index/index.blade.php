@extends('layouts.app')
@section('title', '会员列表')
@section('header', '会员')
@section('header.description', '列表')

@section('content')
	<form class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-1 control-label">手机号：</label>
			<div class="col-sm-2">
                <input type="text" name="phone" value="{{ Arr::get($_GET, 'phone') }}" class="form-control" placeholder="">
			</div>
            <label class="col-sm-1 control-label">时间：</label>
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="created_at_start" value="{{ Arr::get($_GET, 'created_at_start') }}" class="form-control created_at_start">
                </div>
            </div>
            <label class="pull-left control-label">至</label>
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="created_at_end" value="{{ Arr::get($_GET, 'created_at_end') }}" class="form-control created_at_end">
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="查询">
		</div>

		<div class="form-group">


		</div>
	</form>

	<div class="">
		<div class="box-body no-padding">
			<table class="table table-hover table-responsive">
				<tbody>
					<tr>

						<th>ID</th>
						<th>昵称</th>
						<th>头像</th>
						<th>手机号</th>
						<th>状态</th>
                        <th>注册时间</th>
						<th>操作</th>
					</tr>

					@foreach($list as $user)
					<tr>
						<td>{{ $user['id'] }}</td>
						<td>{{ $user['nick_name'] }}</td>
						<td>
                            <img src="{{$user['avatar_url']}}" style="width: 60px;height: 60px;">
                        </td>
						<td>{{ $user['phone'] }}</td>
                        <td>
                            <div class="layui-form " style="margin-top: -8px;"><input type="checkbox" lay-filter="common_change_operation" name="zzz" lay-skin="switch" lay-text="正常|冻结" {{$user['status'] == 1 ? 'checked':''}} data-id="{{$user['id']}}" data-url="{{url('user/index/operation')}}"></div>
                        </td>

						<td>{{ $user['create_time'] }}</td>
						<td>


                        </td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="box-footer clearfix">{{ $list->links() }}</div>
	</div>
@endsection

@section('js')
<script src="{{ asset('admin/moment/min/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('admin/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    commonChange('common_change_operation');
	$('.created_at_start, .created_at_end').datetimepicker({"format":"YYYY-MM-DD", "locale":"zh_cn"});
</script>
@endsection
