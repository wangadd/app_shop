<?php

namespace App\Http\Controllers\cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Goods;
use App\models\Cart;
use App\models\Order;
use App\models\Address;
use Illuminate\Support\Facades\DB;


class PayController extends Controller
{
    /**
     * 点击确认结算  判断条件
     * @param Request $request
     * @return array
     */
    public function payment(Request $request){
        $user_id=session('id');
        if(empty($user_id)){
            $arr=array(
                'status'=>0,
                'msg'=>'您还没有登录，请先登录'
            );
            return $arr;
        }
        $goods_id=$request->input('goods_id');

        $data=Goods::where('goods_id',$goods_id)->first();
        $goods_shelf=$data['goods_shelf'];
        $goods_num=$data['goods_num'];
        if(empty($goods_id)){
            $arr=array(
                'status'=>2,
                'msg'=>'商品不能为空'
            );
            return $arr;
        }
            if($goods_shelf!=1){
                $arr=array(
                    'status'=>1,
                    'msg'=>'商品已下架，再看看其他的吧!'
                );
                return $arr;
            }
            if($goods_num==0){
                $arr=array(
                    'status'=>2,
                    'msg'=>'商品库存不足'
                );
                return $arr;
            }else{
                $arr=array(
                    'status'=>3,
                );
                return $arr;
        }
    }

    /**
     * 生成订单入库
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payshow(Request $request){
        $goods_id=$request->input('goods_id');
        $order_amount=$request->input('price');
        $order_amount=trim($order_amount,"￥");
//       print_r($order_amount);
        $user_id=session('id');
        $order_code=date('YmdHis',time()).rand(1000,9999);
        $orderInfo=[
            'order_no'=>$order_code,
            'user_id'=>$user_id,
            'order_amount'=>$order_amount
        ];
        $res=Order::insert($orderInfo);

        //订单详情入库
        $orderData=Order::where('order_no',$order_code)->get();

        $goods_id=explode(',',$goods_id);
        //两表连查订单详情入库
        $data=Db::table('shop_goods')
            ->join('shop_cart','shop_goods.goods_id','=','shop_cart.goods_id')
            ->whereIn('shop_goods.goods_id',$goods_id)
            ->get();

        foreach($data as $v){
            $arr=[
                'order_id'=>$orderData[0]->order_id,
                'order_no'=>$order_code,
                'goods_id'=>$v->goods_id,
                'user_id'=>$user_id,
                'goods_name'=>$v->goods_name,
                'buy_num'=>$v->buy_num,
                'goods_price'=>$v->goods_price,
                'goods_name'=>$v->goods_name,
                'goods_img'=>$v->goods_img,
                'ctime'=>time(),

            ];
            $res=Db::table('shop_order_detail')->insert($arr);

        }
       $arr=Cart::whereIn('goods_id',$goods_id)->where('user_id',$user_id)->update(['buy_num'=>0,'status'=>2]);

        $addressInfo=Address::where(['user_id'=>$user_id,'check_status'=>1])->first();
    
        $info=[
            'data'=>$data,
            'addressInfo'=>$addressInfo
        ];
        return view('cart.payment',$info);
    }

    /**
     * 收货地址
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payaddress(){
        $user_id=session('id');
        if(empty($user_id)){
            $arr=array(
                'status'=>1,
                'msg'=>'您还没有登录，请先登录!'
            );
            return $arr;
        }
        return view('cart.payaddress');
    }

    /**
     * 添加收货地址
     * @param Request $request
     */
    public function address(Request $request){
        $user_id=session('id');
        $name=$request->input('name');
        $num=$request->input('num');
        $demo1=$request->input('demo1');
        $addr=$request->input('addr');
        $data=[
            'user_id'=>$user_id,
            'username'=>$name,
            'tel'=>$num,
            'region'=>$demo1,
            'address_name'=>$addr
        ];
        $res=Address::insert($data);
        if($res){
            $arr=array(
                'status'=>1,
                'msg'=>'保存成功'
            );
            return $arr;
        }
    }

    /**
     *  展示收货地址
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addressshow(){
        $data=Address::where('status',1)->get();
        return view('cart.address',['data'=>$data]);
    }

    /**
     * 删除收货地址
     * @param Request $request
     * @return array
     */
    public function deladdress(Request $request){
        $address_id=$request->input('address_id');
        $user_id=session('id');
        $where=[
            'address_id'=>$address_id,
            'user_id'=>$user_id
        ];
        $updateInfo=[
            'status'=>2
        ];
        $res=Address::where($where)->update($updateInfo);
        if($res){
            $arr=array(
                'status'=>1,
                'msg'=>'删除成功'
            );
            return $arr;
        }
    }

    /**
     * 修改收货地址  视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request){
        $address_id=$request->input('address_id');
        $data=Address::where('address_id',$address_id)->first();
        return view('cart.upaddress',['data'=>$data]);
    }

    /**
     * 修改收货地址  执行
     * @param Request $request
     */
    public function edit_do(Request $request){
        $data=$request->input();
//        print_r($data);die;
        $res=Address::where('address_id',$data['address_id'])->update($data);
//        print_r($res);die;
        if($res!==false){
            echo 1;
        }else{
            echo 2;
        }
    }

    /**
     * 修改默认选中
     * @param Request $request
     */
    public function checked(Request $request){
        $address_id=$request->input('address_id');
        $where=[
            'address_id'=>$address_id,
        ];
        $info=[
            'check_status'=>1
        ];
        $res1=Address::where($where)->update($info);

        $res2=Address::where('address_id','!=',$address_id)->update(['check_status'=>2]);
        if($res1!==false&&$res2!==false){
            echo 1;
        }else{
            echo 2;
        }
    }

}
