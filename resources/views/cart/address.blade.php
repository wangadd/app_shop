<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>地址管理</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/address.css">
    <link rel="stylesheet" href="css/sm.css">
</head>
<body>

<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">地址管理</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/payaddress" class="m-index-icon">添加</a>
</div>
<div class="addr-wrapp">
    <div class="addr-list">
        <ul>
            @foreach($data as $v)
            <li class="clearfix">
                <span class="fl">{{$v->username}}</span>
                <span class="fr">{{$v->tel}}</span>
            </li>
            <li>
                <p>{{$v->address_name}}</p>
            </li>
            @if($v->check_status==1)
            <li class="a-set " address_id="{{$v->address_id}}">
                <s class="z-set checked" style="margin-top: 6px;"></s>
                <span>设为默认</span>
                <div class="fr">
                    <span class="edit" address_id="{{$v->address_id}}">编辑</span>
                    <span class="remove" address_id="{{$v->address_id}}">删除</span>
                </div>
            </li>
            @else
                <li class="" address_id="{{$v->address_id}}">
                    <s class="z-set checked " style="margin-top: 6px;"></s>
                    <span>设为默认</span>
                    <div class="fr">
                        <span class="edit" address_id="{{$v->address_id}}">编辑</span>
                        <span class="remove" address_id="{{$v->address_id}}">删除</span>
                    </div>
                </li>
            @endif
                <hr/>
            @endforeach
        </ul>
    </div>

</div>


<script src="js/zepto.js" charset="utf-8"></script>
<script src="js/sm.js"></script>
<script src="js/sm-extend.js"></script>
<script src="layui/layui.js"></script>


<!-- 单选 -->
<script>

    $(function(){
        layui.use('layer',function(){
            var layer=layui.layer;
            $('.remove').click(function(){
                var _this=$(this);
                var address_id=_this.attr('address_id');
                var data={};
                data.address_id=address_id
                layer.confirm('您确定要删除吗',function(index){
                    $.ajax({
                        url:"deladdress"
                        ,method:"POST"
                        ,data:data
                        ,dataType:"json"
                        ,success:function(msg){
                            if(msg.status==1){
                                layer.close(index);
                                layer.msg(msg.msg);
                                window.location.reload();
                            }
                        }
                    })
                })
            })
            $('.edit').click(function(){
                var _this=$(this);
                var address_id=_this.attr('address_id');
                location.href="edit?address_id="+address_id+"";
            })
            $('.checked').click(function(){
                var _this=$(this);
                var address_id=_this.parent().attr('address_id');
                $.ajax({
                    url:"checked"
                    ,method:"POST"
                    ,data:{address_id:address_id}
                    ,success:function(res){
                        if(res==1){
                            window.location.reload();
                        
                        }
                    }
                })
            })
        })

    })


    // 删除地址
    // $(document).on('click','span.remove', function () {
    //     var buttons1 = [
    //         {
    //             text: '删除',
    //             bold: true,
    //             color: 'danger',
    //             onClick: function() {
    //                 $.alert("您确定删除吗？");
    //             }
    //         }
    //     ];
    //     var buttons2 = [
    //         {
    //             text: '取消',
    //             bg: 'danger'
    //         }
    //     ];
    //     var groups = [buttons1, buttons2];
    //     $.actions(groups);
    // });
</script>
<script src="js/jquery-1.8.3.min.js"></script>
<script>
    var $$=jQuery.noConflict();
    $$(document).ready(function(){
        // jquery相关代码
        $$('.addr-list .a-set s').toggle(
            function(){
                if($$(this).hasClass('z-set')){

                }else{
                    $$(this).removeClass('z-defalt').addClass('z-set');
                    $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                }
            },
            function(){
                if($$(this).hasClass('z-defalt')){
                    $$(this).removeClass('z-defalt').addClass('z-set');
                    $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                }

            }
        )

    });

</script>



</body>
</html>
