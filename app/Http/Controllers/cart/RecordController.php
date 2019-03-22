<?php

namespace App\Http\Controllers\cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Detail;

class RecordController extends Controller
{
    /**
     * 我的潮购
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userPage(){
        return view('cart.userpage');
    }

    /**
     * 潮购记录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userprofile(){
        $user_id=session('id');
        $where=[
            'user_id'=>$user_id
        ];
        $data=Detail::where($where)->get();
        return view('cart.userprofile',['data'=>$data]);
    }
}
