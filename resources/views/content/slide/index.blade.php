@extends('layouts.app')
@section('title', '轮播图列表')
@section('header', '轮播图')
@section('header.description', '列表')

@section('content')
    <div class="box-header">
        <h3 class="box-title"></h3>
        <div class=" pull-left" >
            <a data-toggle="modal" href="{{ url('content/slide/create') }}" data-target="#myModal" class="btn btn-success btn-sm" rel='add'  ><i class="fa fa-save"></i> 新增</a>
            <a  href="javascript:void(0);"  class="btn btn-danger btn-sm del_batch " data-href="{{url('content/slide/delete')}}" ><i class="fa fa-trash-o"></i> 批量删除</a>

        </div>
    </div>

	<div class="">
		<div class="box-body no-padding">
			<table class="table table-hover table-responsive">
				<tbody>
					<tr>
                        <th><input type="checkbox" class="checkbox-toggle minimal-blue"/></th>
                        <th>排序</th>
						<th>ID</th>
						<th>标题</th>
						<th>url</th>
						<th>图片</th>
						<th>排序</th>
						<th>状态</th>
						<th>创建时间</th>
						<th>操作</th>
					</tr>

					@foreach($list as $slide)
					<tr class="top" item_id="{{ $slide['id']}}">
                        <td><input type="checkbox" value="{{$slide['id']}}" name="id[]" class="minimal-blue"/></td>
                        <td class="sort-handle ui-sortable-handle">
                            <span class="fa fa-align-justify"></span>
                        </td>
						<td>{{ $slide['id'] }}</td>
						<td>{{ $slide['title'] }}</td>
						<td>{{ $slide['url'] }}</td>
						<td>
                            <img src="{{$slide['img']}}" style="height: 100px;">
                        </td>
						<td>{{ $slide['sort'] }}</td>
                        <td>
                            <div class="layui-form " style="margin-top: -8px;"><input type="checkbox" lay-filter="switch_status" name="zzz" lay-skin="switch" lay-text="显示|隐藏" {{$slide['status'] == 1 ? 'checked':''}} data-id="{{$slide['id']}}" data-url="{{url('content/slide/operation')}}"></div>
                        </td>
						<td>{{ $slide['create_time'] }}</td>
						<td>
                            <a class="tip" data-placement="top" data-toggle="tooltip"   style="cursor: pointer" href="{{ url('content/slide/edit') }}?id={{$slide['id']}}" data-original-title="删除" data-target="#myModal"  rel='add'  ><i class="fa fa-pencil"></i> </a>

                            <a style="cursor: pointer" class="tip ajax-delete"  data-toggle="tooltip" data-placement="top"   data-id="{{$slide['id']}}"  data-original-title="删除" href="{{ url('content/slide/delete') }}"><i class="fa fa-trash-o"></i> </a>

                        </td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
{{--		<div class="box-footer clearfix">{{ $list->links() }}</div>--}}
	</div>
@endsection

@section('js')
    <script src="{{asset('admin/jQueryUI/jquery-ui.min.js')}}"></script>
<script>
    $('tbody').sortable({
        items: "tr.top",
        cursor: "pointer",
        axis: "y",
        delay: 100,
        handle: ".sort-handle",
        update: function( event, ui ) {
            var item_ids = $('tbody').sortable("toArray", {attribute : 'item_id'});
            $.ajax({
                type: "post",
                url: "{{url('content/slide/sort')}}",
                data: {ids: item_ids,_token: $('meta[name="csrf-token"]').attr('content')},
                dataType: "json",
                async: false,
                success: function (response) { // data 保存提交后返回的数据，一般为 json 数据
                    if (!response.status) {
                        layer.msg(response.message,{icon:5});
                        $('tbody').sortable("cancel");
                    }else{
                        layer.msg(response.message || '操作成功');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function (response) { // data 保存提交后返回的数据，一般为 json 数据
                    layer.msg(response.message,{icon:5});
                    $('tbody').sortable("cancel");
                    return false;
                }
            });
        }
    });
</script>
@endsection
