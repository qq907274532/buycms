@extends('layouts.app')
@section('title', '编辑文章')
@section('header', '文章')
@section('header.description', '编辑')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/layui/css/layui.css') }}">
@endsection
@section('content')

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
            <div class="box-tools">
                <div class="btn-group pull-right">
                    <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                    <a href="{{ url('content/article/index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;列表</a>
                </div>
            </div>
        </div>

        <form class="form-horizontal role-form" onsubmit="return false;">
            <div class="box-body">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">*</span>文章标题</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="title" placeholder="文章标题" value="{{$info['title']}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">*</span>分类</label>
                        <div class="col-sm-4">
                            <select class="form-control parent_id" name="cat_id" style="width: 100%">
                                {!! $optionHtml !!}
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">*</span>关键字</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="keywords" placeholder="如：test,test"  value="{{$info['keywords']}}">
                            <p class="help-block">多关键词之间用英文逗号隔开</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">*</span>文章来源</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="source" placeholder="文章来源" value="{{$info['source']}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">摘要</label>
                        <div class="col-sm-4">
                            <textarea name="description" class="form-control" rows=3>{{$info['description']}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">*</span>是否推荐</label>
                        <div class="col-sm-4">
                            <label class="radio-inline">
                                <input type="radio" class="minimal-blue" name="is_recommend" value="1" checked> 是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="minimal-blue" name="is_recommend" value="2" {{$info['is_recommend'] == 2 ? 'checked':''}}> 否
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">*</span>是否置顶</label>
                        <div class="col-sm-4">
                            <label class="radio-inline">
                                <input type="radio" class="minimal-blue" name="is_top" value="1" checked> 是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="minimal-blue" name="is_top" value="2" {{$info['is_top'] == 2 ? 'checked':''}}> 否
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">*</span>封面图：</label>
                        <div class="col-sm-9" id="uploader-demo">
                            <!--用来存放item-->
                            <div id="thelist" class="uploader-list row">
                                <div class="col-sm-3">
                                    <input type="hidden" value="{{$info['cover']}}" class="form-control" name="cover">
                                    <img src="{{$info['cover']}}"  style="width: 100%"><a class="btn  btn-primary btn-sm text-center del_btn" style="margin-bottom: 10px;margin-top: 10px;cursor: pointer">删除</a>
                                </div>
                            </div>
                            <div >
                                <button type="button" class="layui-btn" id="test1">
                                    <i class="layui-icon">&#xe67c;</i>上传图片
                                </button>
                            </div>
                        </div>


                    </div>
                    <div class="form-group">

                        <label class="col-sm-2 control-label"><span class="red">*</span>内容</label>
                        <div class="col-sm-8">
                           <textarea id="editor_id" name="content" style="width:700px;height:300px;">{{$info['content']}}</textarea>

                            @include('kindeditor::editor',['editor'=>'editor_id'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-offset-2">
                            <input type="hidden" class="form-control" name="id"   value="{{$info['id']}}">
                            <button type="submit" class="btn btn-primary save">保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('admin/layui/layui.all.js') }}"></script>
    <script src="{{ asset('js/hupload.js') }}?v={{ random_number('9')}}"></script>

    <script>
        $(function () {
            uploadInst({
                id:"#test1",
                uploadUrl:"{{url('/upload_img')}}" ,
                input_name:'cover',
                multiple:false,
                img_id :"#thelist"
            });
        })
        $('.save').click(function() {
            ajaxPostForm($(this), "{{ url('content/article/edit') }}", "{{ url('content/article/index') }}");
        });

    </script>
@endsection
