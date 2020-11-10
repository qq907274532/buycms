@extends('layouts.app')
@section('title', '分类列表')
@section('header', '分类')
@section('header.description', '列表')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/nestable/nestable.css') }}">
@endsection

@section('content')
    <div class="">

        <div class="box-header with-border">

            <div class="btn-group">
                <a class="btn btn-primary btn-sm {{ $treeId }}-tree-tools" data-action="expand">
                    <i class="fa fa-plus-square-o"></i>&nbsp;展开
                </a>
                <a class="btn btn-primary btn-sm {{ $treeId }}-tree-tools" data-action="collapse">
                    <i class="fa fa-minus-square-o"></i>&nbsp;收起
                </a>
            </div>

            <div class="btn-group">
                <a class="btn btn-info btn-sm  {{ $treeId }}-save"><i class="fa fa-save"></i>&nbsp;保存</a>
            </div>

            @if(isset($useRefresh))
                <div class="btn-group">
                    <a class="btn btn-warning btn-sm {{ $treeId }}-refresh"><i class="fa fa-refresh"></i>&nbsp;刷新</a>
                </div>
            @endif

            @if(isset($useCreate))
                <div class="btn-group pull-right">
                    <a data-toggle="modal" href="{{ url($createPath) }}" data-target="#myModal" class="btn btn-success btn-sm" rel='add'  ><i class="fa fa-save"></i> 新增</a>
                </div>
            @endif

        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <div class="dd" id="{{ $treeId }}">
                <ol class="dd-list">
                    @each($branchView, $items, 'branch')
                </ol>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

@endsection

@section('js')
    <script src="{{ asset('admin/nestable/jquery.nestable.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#{{ $treeId }}').nestable({});

            $('.{{ $treeId }}-save').click(function () {
                var serialize = $('#{{ $treeId }}').nestable('serialize');

                $.post('{{ url("content/category/sort") }}', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _order: JSON.stringify(serialize)
                    },
                    function(data){
                        if (data.status) {
                            layer.msg(data.message || '保存成功');
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
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
