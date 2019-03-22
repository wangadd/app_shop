<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Register;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * 注册视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register(){
        return view('user/register');
    }

    /**
     * 注册执行
     * @param Register $register
     * @return array
     */
    public function doadd(Request $request){
        //接收form值
        $arr=$request->input();
        $tel=$arr['name'];
        $pwd=$arr['pwd'];
        $conpwd=$arr['conpwd'];
        $code=$arr['code'];
        //验证非空
        if(empty($tel)){
            $arr=array(
                'status'=>0,
                'msg'=>'请输入您的手机号！',
            );
            return $arr;
        }
        if(empty($pwd)){
            $arr=array(
                'status'=>0,
                'msg'=>'请输入您的密码！',
            );
            return $arr;
        }
        //验证手机号唯一
        $arr=Db::table('shop_register')->where("name",$tel)->first();
        if(!empty($arr)){
            $arr=array(
                'status'=>0,
                'msg'=>'该手机号已存在',
            );
            return $arr;
        }
        //验证密码与确认密码是否一致
        if($pwd!=$conpwd){
            $arr=array(
                'status'=>0,
                'msg'=>'密码和确认密码不一致',
            );
            return $arr;
        }

        $time=time();
        //验证验证码
        $sql="select * from shop_code where tel=$tel and code=$code and timeout > $time and `status`=1";
        $Info=Db::select($sql);
        if(empty($Info)){
            $Info=array(
                'status'=>0,
                'msg'=>'验证码有误',
            );
            return $Info;
        }
        $pwd=md5($pwd);
        $arrInfo=array(
            'name'=>$tel,
            'pwd'=>$pwd,
        );
        $data=Db::table('shop_register')->insert($arrInfo);
        if($data){
            $codeWhere=[
                'code'=>$code,
                'tel'=>$tel
            ];
            $codeUpdate=[
                'status'=>0
            ];
            Db::table('shop_code')->where($codeWhere)->update($codeUpdate);
            $arr=array(
                'status'=>1,
                'msg'=>'注册成功'
            );
            return $arr;
        } else{
            $arr=array(
                'status'=>0,
                'msg'=>'注册失败'
            );
            return $arr;
        }
    }

    /**
     * 登录视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(){
        return view('user/login');
    }

    /**
     * 登录执行
     * @param Request $request
     * @return array|string
     */
    public  function dologin(Request $request){
        $arr=$request->input();
        $name=$arr['txtAccount'];
        $pwd=$arr['txtPassword'];
        $pwd=md5($pwd);
        //验证非空
        if(empty($name)){
            $arr=array(
                'status'=>0,
                'msg'=>'手机号不能为空',
            );
            return $arr;
        }
        if(empty($pwd)){
            $arr=array(
                'status'=>0,
                'msg'=>'密码不能为空',
            );
            return $arr;
        }

        $data=['name'=>$name,'pwd'=>$pwd];
        $user=Db::table('shop_register')->where($data)->first();

        if($user){
            $id=$user->id;
            $name=$user->name;
            session(['id'=>$id,'name'=>$name]);
            $arr=array(
                'status'=>1,
                'msg'=>'登录成功',
            );
            return $arr;
        }else{
            $arr=array(
                'status'=>0,
                'msg'=>'账号或密码错误',
            );
            return $arr;
        }
    }

    /**
     * 发送短信验证码
     * @param Request $request
     */
    public function getcode(Request $Request){
        $tel=$Request->input('tel');
        //生成验证码入库
        $num=rand(1000,9999);
        $bool=100;
//        $obj=new \send();
//        $bool=$obj->show($tel,$num);
        if($bool==100){
            $arr=array(
                'tel'=>$tel,
                'code'=>$num,
                'timeout'=>time()+600000,
                'status'=>1
            );
            $bool=Db::table('shop_code')->insert($arr);
            var_dump($bool);
        }
    }
}
