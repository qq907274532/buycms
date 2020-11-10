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
