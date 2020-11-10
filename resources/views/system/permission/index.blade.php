@extends('layouts.app')
@section('title', '权限列表')
@section('header', '权限')
@section('header.description', '列表')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/nestable/nestable.css') }}">
@endsection

@section('content')
	@include('tree.content')
@endsection

@section('js')
<script src="{{ asset('admin/nestable/jquery.nestable.js') }}"></script>
<script type="text/javascript">
	$(function () {
        $('#{{ $treeId }}').nestable({});

        $('.{{ $treeId }}-save').click(function () {
            var serialize = $('#{{ $treeId }}').nestable('serialize');

            $.post('{{ url("system/permission/sort") }}', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _order: JSON.stringify(serialize)
            },
            function(data){
                if (data.status == true) {
                    window.location.reload();
                } else {
                    layer.msg(data.message || '保存失败');
                }
            });
        });

        $('.{{ $treeId }}-refresh').click(function () {
            window.location.reload();
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
</script>
@endsection