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

<body>
    <div align="center">
    <select name="is_sel" class="is_sel">
        <option value="1">上架</option>
        <option value="2">下架</option>
    </select>
    <select name="hot" class="hot">
        <option value="1">热销</option>
        <option value="2">非热销</option>
    </select>
        <input type="button" value="搜索" id="btn">
    </div>
    <table border="1">
        <tr>
            <td>id</td>
            <td>名称</td>
            <td>分类</td>
            <td>描述</td>
            <td>是否热销</td>
            <td>是否上架</td>
            <td>操作</td>
        </tr>
        @foreach($data as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td value="{{$v->id}}"><span class="name">{{$v->name}}</span></td>
            <td>{{$v->c_name}}</td>
            <td>{{$v->desc}}</td>
            <td>
                @if($v->hot==1)
                    热销
                @else
                    不热销
                @endif
            </td>
            <td>
                @if($v->is_sel==1)
                    上架
                @else
                    下架
                @endif
            </td>
            <td>
                <a href="javascript:;" class="del" id="{{$v->id}}">删除</a>
                <a href="javascript:;" class="update" id="{{$v->id}}">修改</a>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $data->links()}}
</body>
</html>
<script src="/js/jquery-3.1.1.min.js"></script>
<script>
    $(function(){
        //删除
        $('.del').click(function(){
            var _this=$(this);
            var id=_this.attr('id');
            $.ajax({
                url:"del"
                ,method:"POST"
                ,data:{id:id}
                ,success:function(res){
                    if(res==1){
                        alert('删除成功');
                        _this.parents('tr').remove();
                    }else{
                        alert('删除失败');
                    }
                }
            })
        })
        //修改
        $('.update').click(function(){
            var _this=$(this);
            var id=_this.attr('id');
            location.href="update?id="+id+"";
        })
        //即点即改
        $('.name').click(function(){
            var _this=$(this);
            old_val=_this.html();
            _this.parent().html("<input type='\text\' value="+old_val+">");
            $(document).on('blur','input',function(){
                var _this=$(this);
                var id=_this.parent().attr('value');//获取修改之前的值
                var new_val=_this.val();//获取修改之后的值
                $.ajax({
                    url:"upd"
                    ,method:"POST"
                    ,data:{id:id,name:new_val}
                    ,success:function(res){
                        if(res){
                            _this.parent().html("<span class='name'>"+new_val+"</span>");
                            alert('修改成功');
                        }else{
                            _this.parent().html("<span class='name'>"+old_val+"</span>");
                            alert('修改失败');
                        }
                }
                })
            })
        })
        //搜索
        $('#btn').click(function(){
            var is_sel=$('.is_sel').html();
            var hot=$('.hot').html();
            alert(is_sel);
            alert(hot);
        })
    })
</script>