@extends('layouts.app')
@section('title', '角色列表')
@section('header', '角色')
@section('header.description', '列表')

@section('content')
	<div class="">
		<div class="box-header with-border">
			<h3 class="box-title"></h3>
			<div class="box-tools">
                <a data-toggle="modal" href="{{ url('system/role/create') }}" data-target="#myModal" class="btn btn-success btn-sm" rel='add'  ><i class="fa fa-save"></i> 新增</a>
			</div>
		</div>

		<div class="box-body no-padding">
			<table class="table table-hover table-responsive">
				<tbody>
					<tr>
						<th>ID</th>
						<th>角色名称</th>
						<th>角色描述</th>
						<th>状态</th>
						<th>操作</th>
					</tr>

					@foreach($roles as $role)
					<tr>
						<td>{{ $role['id'] }}</td>
						<td>{{ $role['name'] }}</td>
						<td>{{ $role['description'] }}</td>
						<td>
                            <div class="layui-form " style="margin-top: -8px;"><input type="checkbox" lay-filter="switch_status" name="zzz" lay-skin="switch" lay-text="启用|禁用" {{$role['status'] == 1 ? 'checked':''}} data-id="{{$role['id']}}" data-url="{{url('system/role/switch_status')}}"></div>
						</td>
						<td>
							<a class="tip" data-toggle="tooltip" data-placement="top" href="{{ url('system/role/edit') }}?id={{$role['id']}}" data-target="#myModal"  rel='add' data-original-title="编辑"><i class="fa fa-pencil"></i></a>

                            <a class="tip ajax-delete"   data-placement="top" data-toggle="tooltip" href="{{ url('system/role/delete') }}" data-id="{{ $role['id'] }}" data-original-title="删除" ><i class="fa  fa-trash-o"></i></a>

							<a class="tip" data-toggle="tooltip" data-placement="top"  href="{{ url('system/role/permissions') }}?id={{$role['id']}}" data-original-title="权限"><i class="fa fa-ban"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="box-footer clearfix"></div>
	</div>
@endsection
