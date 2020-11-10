<div style="min-width:200px;display:inline-block">

&nbsp;<strong>{{ $list['name'] }}</strong>
</div>
@if($list['status'] == 1)
<span class="label bg-green"> 正常 </span>
@else
<span class="label bg-red"> 停用 </span>
@endif

&nbsp;&nbsp;&nbsp;
