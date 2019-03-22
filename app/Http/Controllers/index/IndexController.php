<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\models\Cart;

class IndexController extends Controller
{
    /**
     * 视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $sql="select * from shop_goods";
        $data=Db::select($sql);
        $sql2="select * from shop_goods where is_tell=1";
        $arr=Db::select($sql2);
        return view('index.index',['data'=>$data,'arr'=>$arr]);
    }

    /**
     * 商品详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request){
        $goods_id=$request->input('goods_id');
        $where="goods_id=$goods_id&& goods_shelf=1";
        $sql="select * from shop_goods where $where";
        $arr=DB::select($sql);

        $user_id=session('id');
        $where=[
            'user_id'=>$user_id
        ];
        $status=[
            'status'=>1,
        ];
        Cart::where('goods_id',$goods_id)->update($status);
        $cartNum=Cart::where($where)->pluck('buy_num')->toArray();
        $data=array_sum($cartNum);
        return view('index.shopcontent',['arr'=>$arr,'data'=>$data]);
    }

    /**
     * 信息流加载
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addli(Request $request){
        $arr=array();
        $page=$request->input('page',1);
        $pageNum=4;//每页显示条数
        //偏移量
        $offset=($page-1)*$pageNum;

        $arrDataInfo=Db::table('shop_goods')->offset($offset)->limit($pageNum)->get();
        //总条数
        $totalData=Db::table('shop_goods')->count();
        //总页数
        $pageTotal=ceil($totalData/$pageNum);
        $objview=view('goods.goodsli',['arrDataInfo'=>$arrDataInfo]);

        $content=response($objview)->getContent();
        $arr['info']=$content;
        $arr['page']=$pageTotal;
        return $arr;
    }
}
