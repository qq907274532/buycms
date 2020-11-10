@extends('layouts.app')
@section('title', '文章列表')
@section('header', '文章')
@section('header.description', '列表')

@section('content')
	<form class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label">标题：</label>
			<div class="col-sm-3">
                <input type="text" name="title" value="{{ Arr::get($_GET, 'title') }}" class="form-control" placeholder="">
			</div>
            <label class="col-sm-1 control-label">分类：</label>
            <div class="col-sm-3">
                <select class="form-control parent_id" name="cat_id" style="width: 100%">
                    <option value="0">请选择分类</option>
                    {!! $optionHtml !!}
                </select>
            </div>
		</div>

		<div class="form-group">
    		<label class="col-sm-2 control-label">时间：</label>
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
            <a  href="{{ url('content/article/create') }}"  class="btn btn-success btn-sm"  ><i class="fa fa-save"></i> 新增</a>
            <a  href="javascript:void(0);"  class="btn btn-danger btn-sm del_batch" data-href="{{url('content/article/delete')}}" ><i class="fa fa-trash-o"></i> 批量删除</a>

		</div>
	</form>

	<div class="">
		<div class="box-body no-padding">
			<table class="table table-hover table-responsive">
				<tbody>
					<tr>
                        <th><input type="checkbox" class="checkbox-toggle minimal-blue"/></th>
						<th>ID</th>
						<th>标题</th>
						<th>发布人</th>
						<th>分类</th>
						<th>点击数</th>
						<th>是否置顶</th>
						<th>是否推荐</th>
						<th>状态</th>
						<th>排序</th>
						<th>发布时间</th>
						<th>操作</th>
					</tr>

					@foreach($list as $article)
					<tr>
                        <td><input type="checkbox" value="{{$article['id']}}" name="id[]" class="minimal-blue"/></td>
						<td>{{ $article['id'] }}</td>
						<td>{{ $article['title'] }}</td>
						<td>{{ $article['operator_name'] }}</td>
						<td>{{ $article->category->name }}</td>
						<td>{{ $article['browser'] }}</td>
                        <td>
                            <div class="layui-form " style="margin-top: -8px;"><input type="checkbox" lay-filter="common_change_recommend" name="zzz" lay-skin="switch" lay-text="是|否" {{$article['is_recommend'] == 1 ? 'checked':''}} data-id="{{$article['id']}}" data-url="{{url('content/article/recommend')}}"></div>
                        </td>
                        <td>
                            <div class="layui-form " style="margin-top: -8px;"><input type="checkbox" lay-filter="common_change_top" name="zzz" lay-skin="switch" lay-text="是|否" {{$article['is_top'] == 1 ? 'checked':''}} data-id="{{$article['id']}}" data-url="{{url('content/article/top')}}"></div>
                        </td>
                        <td>
                            <div class="layui-form " style="margin-top: -8px;"><input type="checkbox" lay-filter="switch_status" name="zzz" lay-skin="switch" lay-text=显示|隐藏 {{$article['status'] == 1 ? 'checked':''}} data-id="{{$article['id']}}" data-url="{{url('content/article/switch_status')}}"></div>
                        </td>
						<td>{{ $article['browser'] }}</td>
						<td>{{ $article['sort'] }}</td>
						<td>{{ $article['create_time'] }}</td>
						<td>
                            <a style="cursor: pointer" href="{{ url('content/article/edit') }}?id={{$article['id']}}" class=" tip action_btn" data-placement="top" data-toggle="tooltip" data-original-title="修改"  ><i class="fa fa-pencil"></i></a>

                            <a  style="cursor: pointer" class="tip ajax-delete" data-placement="top" data-toggle="tooltip"   data-id="{{$article['id']}}"  data-original-title="删除" href="{{ url('content/article/delete')}}"><i class="fa fa-trash-o"></i> </a>

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
    commonChange('common_change_top');
    commonChange('common_change_recommend');
	$('.created_at_start, .created_at_end').datetimepicker({"format":"YYYY-MM-DD", "locale":"zh_cn"});
</script>
@endsection
