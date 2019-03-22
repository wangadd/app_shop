<?php

namespace App\Http\Controllers\cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\models\Goods;
use App\models\Cart;

class CartController extends Controller
{
    /**
     * 加入购物车
     * @param Request $request
     * @return array
     */
    public function addcart(Request $request){
        $goods_id=$request->input('goods_id');
        $goods_name=$request->input('goods_name');
        //取出session  判断是否登录
        $user_id=session('id');
        if(empty($user_id)){
            $arr=array(
              'status'=>0,
              'msg'=>'您还没有登录，请先登录',
            );
            return $arr;
        }
        //根据商品id查询商品一条
        $data=Goods::where('goods_id',$goods_id)->first();
        //判断商品是否上架   库存
        if($data['goods_shelf']!=1){
            $arr=array(
                'status'=>1,
                'msg'=>'商品已下架',
            );
            return $arr;
        }else if($data['goods_num']==0){
            $arr=array(
                'status'=>1,
                'msg'=>'商品库存不足',
            );
            return $arr;
        }
        $where=[
            'goods_id'=>$goods_id,
            'user_id'=>$user_id
        ];
        //查询购物车表
        $arr=Cart::where($where)->first();
        $buy_num=1;
        if(!empty($arr)){
            $num=$arr->buy_num;
            $updateInfo=[
                'buy_num'=>$num+$buy_num,
            ];
            $arr=Cart::where($where)->update($updateInfo);
        }else{
            //添加数据入库
            $data=[
                'goods_id'=>$goods_id,
                'user_id'=>$user_id,
                'create_time'=>time(),
                'goods_name'=>$goods_name,
                'status'=>1,
                'buy_num'=>1
            ];
            $arr=Cart::insert($data);
        }
            if($arr){
                $arr=array(
                    'status'=>1,
                    'msg'=>'商品成功加入购物车',
                );
                return $arr;
        }

    }

    /**
     * 购物车列表视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart(){
        $data=Db::table('shop_goods')
            ->join('shop_cart','shop_goods.goods_id','=','shop_cart.goods_id')
            ->where('status',1)
            ->get();
        $arr=Goods::where('is_tell',1)->get();
        return view('cart.shopcart',['data'=>$data,'arr'=>$arr]);
    }

    /**
     * 购物车列表逻辑删除
     * @param Request $request
     * @return array
     */
    public function del(Request $request){
        $goods_id=$request->input('goods_id');
        $sql="update shop_cart set status=2 where goods_id=$goods_id";
        $arr=Db::update($sql);
        if($arr){
            $arr=array(
                'status'=>1,
                'msg'=>'删除成功'
            );
            return $arr;
        }
    }

    /**
     * 判断最大库存  点击加号
     * @param Request $request
     * @return array
     */
    public function getGoodsNum(Request $request){
        $user_id=session('id');
        $goods_id=$request->input('goods_id');
        //获取商品最大库存
        $arr=Goods::where('goods_id',$goods_id)->first();
        $goods_num=$arr->goods_num;

        $where=[
            'goods_id'=>$goods_id,
            'user_id'=>$user_id,
        ];
        //获取购买数量
        $data=Cart::where($where)->first();
        $num=$data->buy_num;
        if($goods_num>$num){
            $updateInfo=[
                'buy_num'=>$num+1,
            ];
        }else{
            $updateInfo=[
                'buy_num'=>$goods_num,
            ];
            $arr=array(
                'status'=>0,
                'msg'=>'库存不足',
                'buy_num'=>$num
            );
            return $arr;
        }
       $data=Cart::where($where)->update($updateInfo);
    }

    /**
     * 点击减号
     * @param Request $request
     * @return array
     */
    public function min(Request $request){
        $user_id=session('id');
        $goods_id=$request->input('goods_id');
        $where=[
            'user_id'=>$user_id,
            'goods_id'=>$goods_id,
        ];
        $data=Cart::where($where)->first();
        $num=$data->buy_num;

        if($num>1) {
            $updateInfo = [
                'buy_num' => $num - 1,
            ];
        }else{
            $updateInfo=[
                'buy_num'=>1
            ];
            $arr=array(
                'status'=>0,
                'msg'=>'没有更少了'
            );
            return $arr;
        }
        $data=Cart::where($where)->update($updateInfo);
    }

    /**
     * 获取文本框的值  判断最大库存
     * @param Request $request
     */
    public function getNum(Request $request){
        $goods_id=$request->input('goods_id');
        //获取文本框的值
        $num=$request->input('num');

        $user_id=session('id');
        $where=[
            'goods_id'=>$goods_id,
            'user_id'=>$user_id,
        ];

        $data=Goods::where('goods_id',$goods_id)->first();
        $goods_num=$data->goods_num;

        if($num<=0){
            $arr=array(
                'status'=>1,
                'goods_num'=>1,
                'msg'=>'商品数量不能少于1！'
            );
            return $arr;
        }


        if($num>$goods_num){
              $updateInfo=[
                  'buy_num'=>$goods_num,
              ];
            $data=Cart::where($where)->update($updateInfo);
              $arr=array(
                  'status'=>1,
                  'buy_num'=>$goods_num,
                  'msg'=>'商品数量超过最大库存'
              );
              return $arr;

        }else{
            $updateInfo=[
                'buy_num'=>$num,
            ];
            $data=Cart::where($where)->update($updateInfo);
        }
    }

    /**
     * 批量删除
     * @param Request $request
     * @return array
     */
    public function deleteAll(Request $request){
        $goods_id=$request->input('goods_id');
        $user_id=session('id');
        $where=[
            'user_id'=>$user_id
        ];
        $updateInfo=[
            'create_time'=>time(),
            'status'=>2,
            'buy_num'=>0
        ];
        $arr=Cart::whereIn('goods_id',$goods_id)->update($updateInfo);
        if($arr){
            $arr=array(
                'status'=>1,
                'msg'=>'删除成功'
            );
            return $arr;
        }
    }
}