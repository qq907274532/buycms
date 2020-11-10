<div style="min-width:200px;display:inline-block">
@if($permission['menu_icon'])<i class="fa {{ $permission['menu_icon'] }}"></i>@endif
&nbsp;<strong>{{ $permission['name'] }} @if($permission['slug']) - {{ $permission['slug'] }}@endif</strong>
</div>

<span class="label label-primary">{{ $permission['type'] == 1 ? '页面' : '菜单' }}</span>

&nbsp;&nbsp;&nbsp;
@if($permission['status'] == 1)
<span class="label bg-green"> 正常 </span>
@else
<span class="label bg-red"> 停用 </span>
@endif

&nbsp;&nbsp;&nbsp;
<code>{{ $permission['wild_uri'] }}</code>