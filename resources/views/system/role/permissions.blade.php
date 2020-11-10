@extends('layouts.app')
@section('title', '角色权限设置')
@section('header', '角色权限')
@section('header.description', '编辑')

@section('css')
   <link rel="stylesheet" href="{{ url('admin/nestable/nestable.css') }}">
@endsection

@section('content')
	@include('tree.content')
@endsection

@section('js')
<script src="{{ url('admin/nestable/jquery.nestable.js') }}"></script>
<script type="text/javascript">
	$(function () {
        $('#{{ $treeId }}').nestable({
        	handleClass: 'xxx',//一个不存在的class防止拖拽
        });

        $('.{{ $treeId }}-save').click(function () {
        	var permission_ids = [];
            $('input[name="permission_ids[]"]:checked').each(function() {
            	permission_ids.push($(this).val());
            });

            $.post('{{ url("system/role/permissions") }}?id={{ $role["id"] }}', {
                permission_ids: permission_ids,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function(ret) {
            	if(ret.status == true) {
                    window.location.reload();
            	} else {
                    layer.msg(data.message || '保存失败');
                }
            }, 'json');
        });

        $('.{{ $treeId }}-tree-tools').on('click', function(e){
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse') {
                $('.dd').nestable('collapseAll');
            }
        });
    });

    $('.role').on('ifChecked', function(event){
        $(this).parent().parent().siblings().find('input').iCheck('check');
    })

    $('.role').on('ifUnchecked', function(event){
        $(this).parent().parent().siblings().find('input').iCheck('uncheck');
    })
</script>
@endsection
