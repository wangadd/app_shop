<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form id="form">
    <input type="hidden" name="id" value="{{$data[0]->id}}">
    <table border="1">
        <tr>
            <td>名称</td>
            <td><input type="text" name="name" id="name" value="{{$data[0]->name}}"></td>
        </tr>
        <tr>
            <td>分类</td>
            <td>
                <select name="c_id" id="cate">
                    @foreach($arr as $v)
                        @if($data[0]->c_id==$v->c_id)
                            <option value="{{$v->c_id}}" selected>{{$v->c_name}}</option>
                        @else
                            <option value="{{$v->c_id}}">{{$v->c_name}}</option>
                        @endif
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>描述</td>
            <td><textarea name="desc" id="desc" cols="30" rows="10">{{$data[0]->desc}}</textarea></td>
        </tr>
        <tr>
            <td>是否热销</td>
            <td>
                @if($data[0]->hot==1)
                    是<input type="radio" name="hot" value="1" checked>
                    否<input type="radio" name="hot" value="2">
                @else
                    是<input type="radio" name="hot" value="1">
                    否<input type="radio" name="hot" value="2" checked>
                @endif
            </td>
        </tr>
        <tr>
            <td>是否上架</td>
            <td>
                @if($data[0]->is_sel==1)
                    是<input type="radio" name="is_sel" value="1" checked>
                    否<input type="radio" name="is_sel" value="2">
                @else
                    是<input type="radio" name="is_sel" value="1">
                    否<input type="radio" name="is_sel" value="2" checked>
                @endif
            </td>
        </tr>
        <tr>
            <td><input type="submit" value="确定" id="btn"></td>
            <td></td>
        </tr>
    </table>
</form>
</body>
</html>
<script src="/js/jquery-3.1.1.min.js"></script>
<script>
    $(function(){
        $('#btn').click(function(){
            var data =$('#form').serialize();
            $.ajax({
                url:"update_do"
                ,data:data
                ,method:"POST"
                ,success:function(res){
                    if(res==1){
                        alert('修改成功');
                        location.href="show";
                    }else{
                        alert('修改失败');
                    }
                }
            })
            return false;
        })
    })
</script>