<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function test(Request $request){
        //页码
        $page=empty($_GET['page'])?"":$_GET['page'];
        //接收搜索框的值
        $goods_name=empty($_GET['goods_name'])?"":$_GET['goods_name'];

        $memcache=new \Memcache();
        //连接memcache
        $memcache->connect('127.0.0.1',11211);

        $key="p_$page"."g_$goods_name";

        if($memcache->get($key)){
            echo 111111111;
            //在缓存中取数据
            $data=$memcache->get($key);
        }else{
            //存缓存
            $data=Db::table('shop_goods')
                ->where('goods_name','like',"%$goods_name%")
                ->orderBy('goods_id','asc')
                ->paginate(5);
            $time=time()+10;
            $memcache->set($key,$data,MEMCACHE_COMPRESSED,$time);
            echo 2222;
        }
        return view('test',['data'=>$data,'goods_name'=>$goods_name]);
    }
}