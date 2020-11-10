<li class="dd-item" data-id="{{ $branch[$keyName] }}">
    <div class="dd-handle">
        {!! $branchCallback($branch) !!}

        <span class="pull-right dd-nodrag">
             @if(isset($useEdit))
             <a class="tip" data-toggle="tooltip" data-placement="top"  href="{{ url($editPath) }}?id={{ $branch[$keyName] }}" data-target="#myModal"  rel='add'  data-original-title="编辑" ><i class="fa fa-pencil"></i>&nbsp;</a>

            @endif
                 @if(isset($useOperation))
                     <a   href="{{ url($operationPath) }}" data-id="{{ $branch[$keyName] }}" class="ajax-delete" data-original-title="删除" ><i class="fa fa-trash-o"></i>&nbsp;</a>
                 @endif
        </span>




    </div>
    @if(isset($branch['children']))
    <ol class="dd-list">
        @foreach($branch['children'] as $branch)
            @include('content.tree.branch', $branch)
        @endforeach
    </ol>
    @endif
</li>
