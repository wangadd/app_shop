<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>填写收货地址</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/writeaddr.css">
    <link rel="stylesheet" href="layui/css/layui.css">
    <link rel="stylesheet" href="dist/css/LArea.css">
</head>
<body>

<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">填写收货地址</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="" class="m-index-icon" >保存</a>
</div>
<div class=""></div>
<!-- <form class="layui-form" action="">
  <input type="checkbox" name="xxx" lay-skin="switch">

</form> -->
<form class="layui-form" action=""id="formDemo">

    <input type="hidden" name="address_id" value="{{$data['address_id']}}">
    <div class="addrcon">
        <ul>
            <li>
                <em>收货人</em>
                <input type="text" name="username" id="name" value="{{$data['username']}}">
            </li>
            <li>
                <em>手机号码</em>
                <input type="number"  name="tel" id="num" value="{{$data['tel']}}">
            </li>
            <li>
                <em>所在区域</em>
                <input id="demo1" type="text" name="region" value="{{$data['region']}}">
            </li>
            <li class="addr-detail">
                <em>详细地址</em>
                <input type="text" name="address_name" value="{{$data['address_name']}}" class="addr">
            </li>
        </ul>
    </div>
</form>
</body>
</html>
<script src="dist/js/LArea.js"></script>
<script src="dist/js/LAreaData1.js"></script>
<script src="dist/js/LAreaData2.js"></script>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="layui/layui.js"></script>
<script>
    $(function(){
        $('.m-index-icon').click(function(){
            var data =$('#formDemo').serialize();
            $.ajax({
                url:"edit_do"
                ,method:"POST"
                ,data:data
                ,success:function(res){
                    // console.log(res)
                    if(res==1){
                        alert('修改成功');
                        window.location.href="addressshow";
                    }else{
                        alert('修改失败');
                    }
                }
            })
            return false;
        })
    })
</script>