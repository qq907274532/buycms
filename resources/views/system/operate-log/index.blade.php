@extends('layouts.app')
@section('title', '日志列表')
@section('header', '日志')
@section('header.description', '列表')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('content')
	<form class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label">操作人</label>
			<div class="col-sm-3">
                <input type="text" name="username" value="{{ Arr::get($_GET, 'username') }}" class="form-control" placeholder="">
			</div>
            <label class="col-sm-1 control-label">操作</label>
            <div class="col-sm-3">
                <input type="text" name="action" value="{{ Arr::get($_GET, 'action') }}" class="form-control" placeholder="">
            </div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">操作URI</label>
			<div class="col-sm-3">
					<input type="text" name="action_uri" value="{{ Arr::get($_GET, 'action_uri') }}" class="form-control" placeholder="右模糊匹配">
			</div>

			<label class="col-sm-1 control-label">资源ID</label>
			<div class="col-sm-3">
					<input type="text" name="resource_id" value="{{ Arr::get($_GET, 'resource_id') }}" class="form-control" placeholder="">
			</div>
		</div>
		<div class="form-group">
    		<label class="col-sm-2 control-label">操作时间</label>
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
	</form>

	<div class="">
		<div class="box-body no-padding">
			<table class="table table-hover table-responsive">
				<tbody>
					<tr>
						<th>ID</th>
						<th>操作人</th>
						<th>操作</th>
						<th>资源ID</th>
						<th>操作结果</th>
						<th>操作时间</th>
					</tr>

					@foreach($logs as $log)
					<tr>
						<td>{{ $log['id'] }}</td>
						<td>{{ $log['username'] }}</td>
						<td>{{ $log['action'] }}</td>
						<td>{{ $log['resource_id'] }}</td>
						<td>{{ $log['result'] }}</td>
						<td>{{ $log['created_at'] }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="box-footer clearfix">{{ $logs->links() }}</div>
	</div>
@endsection

@section('js')
<script src="{{ asset('admin/moment/min/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('admin/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
	$('.created_at_start, .created_at_end').datetimepicker({"format":"YYYY-MM-DD", "locale":"zh_cn"});
</script>
@endsection
