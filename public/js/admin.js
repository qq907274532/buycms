var form;

$(function () {

    $(document).on('click','.del_btn',function () {
        if(confirm("您确定要删除该图片吗？")){
            $(this).parent().remove();
            return true;
        }
        return false;

    })

    commonChange('switch_status')

    /*消息提示框自动隐藏*/
    $("#alert_message").delay(5000).hide(0);
    $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    $('#myModal').modal({
        backdrop:'static',
        keyboard: false
    })
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    //全部选中checkbox
    $('.checkbox-toggle').on('ifChecked', function(event){
        $("input[type='checkbox'][class!='checkbox-toggle']").iCheck('check');
    });

    //全部取消选中checkbox
    $('.checkbox-toggle').on('ifUnchecked', function(event){
        $("input[type='checkbox'][class!='checkbox-toggle']").iCheck('uncheck');
    });

    $(document).on("click", "a[rel='add']", function (event) {
        event.preventDefault();
        var url = $(this).attr('href');
        var dialog = bootbox.dialog({
            title: '',
            show:false,
            message: '<p class="text-center"><i class="glyphicon glyphicon-signal"></i> 加载中...</p>',
            buttons: {
                cancel: {
                    label: '取消',
                    className: 'btn-default'
                },
                ok: {
                    label: "确认",
                    className: 'btn-info',
                    callback: function(){
                        $.ajax({
                            type: "post",
                            url: url,
                            data: $('form').serializeArray(),
                            dataType: "json",
                            success: function(ret) {
                                if(ret.status) {
                                    layer.msg(ret.message || '操作成功',{
                                        icon: 1,
                                        time: 500
                                    }, function() {
                                        if(ret.url != undefined) {
                                            window.location.href = ret.url
                                        } else {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    layerMsgRed(ret.message || '操作失败');
                                }
                            },
                            error: function() {
                                layerMsgRed('请求异常，请稍后再试');
                            }

                        });
                        return true;
                    }
                }
            },
        });
        dialog.init(function(){
            $.get(url, function(res) {
                if(typeof res == 'object'){
                    layerMsgRed(res.message|| '系统故障');
                }else{
                    dialog.find('.bootbox-body').html(res);
                    dialog.modal('show');
                }
            });

        });
    });
    /**
     * 通用状态操作
     */
    $(document).on("click",".ajax-delete-status",function () {
        var _href = $(this).attr('href');
        var msg = $(this).data('original-title');
        var id = $(this).data('id');
        layer.open({
            shade: false,
            content: '确定'+msg+'吗？',
            btn: ['确定', '取消'],
            yes: function (index) {
                $.ajax({
                    url: _href,
                    type: "POST",
                    data:{id:id},
                    success: function (info) {
                        if (info.status) {
                            layer.msg(info.message||'操作成功',{icon:1});
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }else{
                            layer.msg(info.message||'系统异常',{icon:5});
                        }
                    },
                    error:function (info) {
                        layer.msg(info.message||'系统异常',{icon:5});
                        return false;
                    }
                });
                layer.close(index);
            }
        });

        return false;
    });
    /**
     * 删除操作
     */
    $(document).on("click",".ajax-delete",function () {

        var _href = $(this).attr('href');
        var id = $(this).data('id');
        layer.open({
            shade: false,
            content: '确定删除吗？',
            btn: ['确定', '取消'],
            yes: function (index) {
                $.ajax({
                    url: _href,
                    type: "post",
                    data:{id:id},
                    success: function (info) {
                        if (info.status) {
                            layer.msg(info.message||'操作成功',{icon:1});
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }else{
                            layer.msg(info.message||'系统异常',{icon:5});
                        }
                    },
                    error:function (info) {
                        layer.msg(info.message||'系统异常',{icon:5});
                        return false;
                    }
                });
                layer.close(index);
            }
        });

        return false;
    });
    $(document).on("click",".del_batch",function () {
        var _href = $(this).data('href');
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        layer.open({
            shade: false,
            content: '确定删除吗？',
            btn: ['确定', '取消'],
            yes: function (index) {
                $.ajax({
                    url: _href,
                    type: "post",
                    data:{id:ids},
                    success: function (info) {
                        if (info.status) {
                            layer.msg(info.message||'操作成功',{icon:1});
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }else{
                            layer.msg(info.message||'系统异常',{icon:5});
                        }
                    },
                    error:function (info) {
                        layer.msg(info.message||'系统异常',{icon:5});
                        return false;
                    }
                });
                layer.close(index);
            }
        });

        return false;
    });

})
layui.use('form', function(){
    form = layui.form;
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



function ajaxPostForm(obj, action, redirectUrl) {
    var _this = obj;
    _this.prop("disabled", true);

    $.ajax({
        type: "post",
        url: action,
        data: $('form').serializeArray(),
        dataType: "json",
        success: function(ret) {
            if(ret.status == true) {
                layer.msg(ret.message || '操作成功',{
                    icon: 1,
					time: 500
                }, function() {
                    if(redirectUrl != undefined) {
                        window.location.href = redirectUrl
                    } else {
                        window.location.reload();
                    }
                });
            } else {
                layerMsgRed(ret.message || '操作失败');
                _this.prop("disabled", false)
            }
        },
        error: function() {
            layerMsgRed('请求异常，请稍后再试');
            _this.prop("disabled", false)
        }
    });
}

function layerAjax(action, data, redirectUrl, windowObj) {
    var loadindex = layer.load();
    var windowObj = windowObj || window;
    $.ajax({
        type: "post",
        url: action,
        data: data,
        dataType: "json",
        success: function(ret) {
            layer.close(loadindex);
            if(ret.status == true) {
                layer.msg(ret.message || '操作成功',{
                    icon : 1,
					time: 500
                }, function() {
                    if(redirectUrl != undefined && redirectUrl != '') {
                        windowObj.location.href = redirectUrl
                    } else {
                        windowObj.location.reload();
                    }
                });
            } else {
                layerMsgRed(ret.message || '操作失败，请稍后再试')
            }
        },
        error: function() {
            layer.close(loadindex);
            layerMsgRed('操作失败，请稍后再试')
        }
    });
}

function layerMsgRed(msg) {
    layer.msg(msg, {icon: 2});
}

function commonChange(clickEvent) {
    //监听提交
    form.on('switch('+clickEvent+')', function(data){
        var _this = $(this);
        var id = _this.data('id');
        var url = _this.data('url');

        layer.open({
            shade: false,
            content: '确定执行该操作吗？',
            btn: ['确定', '取消'],
            yes: function (index) {
                $.ajax({
                    type: "post",
                    url: url,
                    data: {id:id},
                    dataType: "json",
                    success: function(ret) {
                        if(ret.status) {
                            layer.msg(ret.message || '操作成功',{
                                icon: 1,
                                time: 500
                            }, function() {
                                window.location.reload();
                            });
                        } else {
                            layerMsgRed(ret.message || '操作失败',{
                                icon: 2,
                                time: 500
                            }, function() {
                                window.location.reload();
                            });
                        }
                    },
                    error: function() {
                        layerMsgRed('请求异常，请稍后再试',{
                            icon: 2,
                            time: 500
                        }, function() {
                            window.location.reload();
                        });
                    }

                });
                layer.close(index);
            },
            end:function (){
                window.location.reload();
            }
        });

    });
}
