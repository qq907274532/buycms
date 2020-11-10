<li class="dd-item" data-id="{{ $branch[$keyName] }}">
    <div class="dd-handle" >
        {!! $branchCallback($branch) !!}
        <span class="pull-right dd-nodrag">
           @if(isset($useEdit))
                 <a class="tip" data-toggle="tooltip" data-placement="top" href="{{ url($editPath) }}?id={{ $branch[$keyName] }}" data-target="#myModal"  rel='add'  data-original-title="编辑" ><i class="fa fa-pencil"></i></a>
        @endif
            @if(isset($useDelete))
             <a class="tip ajax-delete"  data-toggle="tooltip" data-placement="top" href="{{ url($deletePath) }}" data-original-title="删除"  data-target="#myModal" data-id="{{ $branch[$keyName] }}"><i class="fa fa-trash-o"></i></a>
            @endif
             </span>
    </div>
    @if(isset($branch['children']))
    <ol class="dd-list">
        @foreach($branch['children'] as $branch)
            @include('tree.branch', $branch)
        @endforeach
    </ol>
    @endif
</li>
