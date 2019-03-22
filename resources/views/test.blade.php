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
<form action="/test" method="get">
    <input type="text" name="goods_name" value="{{$goods_name}}">
    <input type="submit" value="搜索">
</form>
    <table border="1">
        <tr>
            <td>商品id</td>
            <td>商品名称</td>
            <td>商品价格</td>
            <td>是否热卖</td>
        </tr>
        @foreach($data as $v)
        <tr>
            <td>{{$v->goods_id}}</td>
            <td>{{$v->goods_name}}</td>
            <td>{{$v->goods_price}}</td>
            <td>
                @if($v->is_tell==1)
                    热卖
                @else
                    非热卖
                @endif
            </td>
        </tr>
        @endforeach
    </table>
    {{$data->appends(['goods_name'=>$goods_name])->links()}}
</body>
</html>