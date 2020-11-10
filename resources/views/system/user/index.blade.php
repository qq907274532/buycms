@extends('layouts.app')
@section('title', '用户列表')
@section('header', '用户')
@section('header.description', '列表')

@section('content')
	<div class="">
		<div class="box-header with-border">
			<h3 class="box-title"></h3>
			<div class="box-tools">
                <a data-toggle="modal" href="{{ url('system/user/create') }}" data-target="#myModal" class="btn btn-success btn-sm" rel='add'  ><i class="fa fa-save"></i> 新增</a>

			</div>
		</div>

		<div class="box-body no-padding">
			<table class="table table-hover table-responsive">
				<tbody>
					<tr>
						<th>ID</th>
						<th>用户名称</th>
						<th>真实姓名</th>
						<th>角色</th>
						<th>状态</th>
						<th>创建时间</th>
						<th>操作</th>
					</tr>

					@foreach($users as $user)
					<tr>
						<td>{{ $user['id'] }}</td>
						<td>{{ $user['username'] }}</td>
						<td>{{ $user['realname'] }}</td>
						<td>
							@foreach($user['roles'] as $role)
							<span class="label bg-green"> {{ $role['name'] }} </span>&nbsp;
							@endforeach
						</td>
						<td>
                            <div class="layui-form " style="margin-top: -8px;"><input type="checkbox" lay-filter="switch_status" name="zzz" lay-skin="switch" lay-text="启用|禁用" {{$user['status'] == 1 ? 'checked':''}} data-id="{{$user['id']}}" data-url="{{url('system/user/switch_status')}}"></div>
						</td>
						<td>{{ $user['created_at'] }}</td>
						<td class="tooltip-demo">
							@if(!$user->isAdministrator())
                                <a class="tip" data-placement="top" data-toggle="tooltip" href="{{ url('system/user/edit') }}?id={{ $user['id'] }}"  data-target="#myModal"  rel='add'   data-original-title="编辑"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="tip ajax-delete"   data-placement="top" data-toggle="tooltip" href="{{ url('system/user/delete') }}" data-id="{{ $user['id'] }}" data-original-title="删除" ><i class="fa  fa-trash-o"></i></a>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="box-footer clearfix">
			{{ $users->links() }}
		</div>
	</div>
@endsection
