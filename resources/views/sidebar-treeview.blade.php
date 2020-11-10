@foreach($permissions as $permission)
@if($level == 1)
<li class="treeview">
@else
<li>
@endif
	<a href="{{ !in_array($permission['menu_uri'], ['', '#']) ? url($permission['menu_uri']) : 'javascript:;' }}" target="mainFrame">
		@if($level > 1) &nbsp;&nbsp; @endif<i class="fa {{ $permission['menu_icon'] }}"></i><span>{{ $permission['name'] }}</span>
		@if(isset($permission['children']))
		<i class="fa fa-angle-left pull-right"></i>
		@endif
	</a>
	@if(isset($permission['children']))
	<ul class="treeview-menu">
		@include('sidebar-treeview', ['permissions' => $permission['children'], 'level' => $level+1])
	</ul>
	@endif
</li>
@endforeach
