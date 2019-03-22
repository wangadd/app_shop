<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    table{border:1px solid #666;border-collapse: collapse;width:900px;margin:10px auto;font-size: 14px;color:#666;}
    th,td{border:1px solid #666;height:25px;text-align:center;}
    a{border:1px solid #666;text-decoration: none;padding: 0 5px;border-radius: 5px;color:#666;}
    a:hover,a.current{border:1px solid plum;color:plum;}
    ul li{
        text-decoration: none;
        padding: 0 5px;
        border-radius: 5px;
        color:orange;
        list-style:none;
        float:left;
        font-size:20px;
        margin-left:10px;

    }
    ul li a{
        text-decoration: none;
    }
    ul{
        margin-left:400px;

    }
</style>

<style>
    ul li{
        text-decoration: none;
        padding: 0 5px;
        border-radius: 5px;
        list-style:none;
        float:left;
        font-size:20px;
    }
    ul li a{
        text-decoration: none;
    }
</style>
<body>
<form action="/show" method="get" align="center">
    <input type="text" name="goods_name" value="{{$goods_name}}">
    @if($is_tell==1)
        <select name="is_tell">
            <option value="">是否潮荐</option>
            <option value="1" selected>是</option>
            <option value="2">否</option>
        </select>
    @else
        <select name="is_tell">
            <option value="">是否潮荐</option>
            <option value="1">是</option>
            <option value="2" selected>否</option>
        </select>
    @endif
    <input type="submit" value="搜索">
</form>
<table border="1">
    <tr>
        <td>商品id</td>
        <td>商品名称</td>
        <td>商品价格</td>
        <td>图片</td>
        <td>是否热销</td>
    </tr>
   @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->goods_id}}</td>
        <td>{{$v->goods_name}}</td>
        <td>{{$v->goods_price}}</td>
        <td><img src="{{URL::asset('uploads/'.$v->goods_img)}}" width="50px" height="50px"></td>
        <td>
            @if($v->is_tell==1)
                热销
            @else
                非热销
            @endif
        </td>
    </tr>
    @endforeach

</table>
{{ $data->appends(['goods_name' => $goods_name,'is_tell'=>$is_tell])->links() }}
{{--{{$data->links()}}--}}
</body>
</html>