@extends('layouts.app')
@section('css')
	<style type="text/css">
		div.callout.callout-danger {
			background-color: #f56954 !important;
		}
	</style>
@endsection

@section('content')
	<div class="box">
		<div class="box-header with-border">
            <i class="icon fa fa-ban"></i>
            <h3 class="box-title">出错啦！！！</h3>
        </div>
        <div class="box-body">
		    <div class="callout callout-danger">
		        <p>{{ $message }}</p>
		    </div>
	    </div>
    </div>
@endsection