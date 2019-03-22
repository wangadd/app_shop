<?php

namespace App\Http\Controllers\goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\models\Cate;
use App\models\Goods;

class GoodsController extends Controller
{
    /**
     * 递归获取分类下的id
     * @param $info
     * @param $pid
     * @return array
     */
    public function getCateId($info,$pid){
        static $id=[];
        foreach($info as $k=>$v){
            if($v['pid']==$pid){
                $id[]=$v['cate_id'];
                $this->getCateId($info,$v['cate_id']);
            }
        }
        return $id;
    }

    /**
     * 查询分类数据
     * @param Request $request
     * @return array
     */
    public function allshops(Request $request){
        $cateInfo=Cate::where('pid','=',0)->get();
        $data=Goods::where('goods_shelf',1)->get();
        return view('goods.allshops',['cateInfo'=>$cateInfo,'data'=>$data]);

    }

    /**
     * 商品分类
     * @param Request $request
     * @return array
     */
    public function shopsli(Request $request){
        $arr=array();
        $cate_id=$request->input('cate_id');
        $goodsInfo=Goods::where('goods_shelf',1)->orderBy('goods_price','desc');
        if($cate_id){
            $cateInfo=Cate::get();
            $cate_id=$this->getCateId($cateInfo,$cate_id);
            $goodsInfo=$goodsInfo->whereIn('cate_id',$cate_id);
        }
        $goodsInfo=$goodsInfo->get();
        $objview=view('goods.shopsli',['goodsInfo'=>$goodsInfo]);
        $content=response($objview)->getContent();
        $arr['info']=$content;
        return $arr;
    }

}