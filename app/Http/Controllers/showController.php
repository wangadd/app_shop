<?php

namespace App\Http\Controllers;

use App\models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Show;

class showController extends Controller
{
    public function show(Request $request){
//        $page=$request->input();
        $memcache=new \Memcache();
        $memcache->connect('127.0.0.1',11211);
        //接收搜索框的值
        $goods_name=empty($_GET['goods_name'])?"":$_GET['goods_name'];
        $is_tell=empty($_GET['is_tell'])?"":$_GET['is_tell'];

//        $goods_name=$request->input('goods_name');
        $page=empty($_GET['page'])?1:$_GET['page'];
        $key="page_$page"."$goods_name"."$is_tell";

        if($memcache->get($key)){
            echo 55;
            $data=$memcache->get($key);
        }else{
            echo 88;
            if(empty($is_tell)){
                $data=Db::table('shop_goods')
                    ->where('goods_name','like', "%$goods_name%")
                    ->orderBy('goods_id','asc')
                    ->paginate(5);
            }else{
                $where=[
                    'is_tell'=>$is_tell
                ];
                $data=Db::table('shop_goods')
                    ->where('goods_name','like', "%$goods_name%")
                    ->where($where)
                    ->orderBy('goods_id','asc')
                    ->paginate(5);
            }

            $time=time()+10;
            $memcache->set($key,$data,MEMCACHE_COMPRESSED,$time);
        }
        return view('show',['data'=>$data,'goods_name'=>$goods_name,'is_tell'=>$is_tell]);
    }
}
