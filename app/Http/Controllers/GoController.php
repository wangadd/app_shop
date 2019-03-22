<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoController extends Controller
{
    /**
     * 添加视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $sql="select * from cate";
        $arr=DB::select($sql);
//        print_r($arr);die;
        return view('practice.add',['arr'=>$arr]);
    }

    /**
     * 添加执行
     * @param Request $request
     * @return int
     */
    public function doadd(Request $request)
    {
        $data = $request->input();
//        print_r($data);die;
        $res = Db::table('book')->insert($data);
        if ($res) {
            return 1;
        } else {
            return 2;
        }
    }

    /**
     * * 列表展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
        public function show(Request $request){
//            $data=$request->input('data');
//            print_r($data);
//            $where=[
//                'hot'=>$hot,
//                'is_sel'=>$sel
//            ];
            $data=Db::table('book')
                    ->join('cate','book.c_id','=','cate.c_id')
                    ->where('is_del','=','1')
                    ->select()
                    ->paginate(5);
            return view('practice.show',['data'=>$data]);
        }

    /**
     * 删除
     * @param Request $request
     * @return int
     */
        public function del(Request $request){
            $id=$request->input('id');
//            print_r($id);exit;
            $sql="update book set is_del=2 where id=$id";
            $res=Db::update($sql);
            if($res){
                return 1;
            }else{
                return 2;
            }
        }

    /**
     * 修改视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
        public function update(Request $request){
            $id=$request->input('id');
            $catesql="select * from cate";
            $booksql="select * from book where id=$id";
            $arr=Db::select($catesql);
            $data=Db::select($booksql);
            return view('practice.update',['arr'=>$arr,'data'=>$data]);
        }

    /**
     * 修改执行
     * @param Request $request
     */
        public function update_do(Request $request){
            $data=$request->input();
//            print_r($data);die;
            $res=Db::table('book')->where('id','=',$data['id'])->update($data);
            if($res!==false){
                echo 1;
            }else{
                echo 2;
            }
        }

    /**
     * 即点即改
     * @param Request $request
     * @return int
     */
        public function upd(Request $request){
            $data=$request->input();
            $res=Db::table('book')->where('id','=',$data['id'])->update($data);
            if($res){
                return 1;
            }else{
                return 2;
            }
        }













    //添加
//    public function add(){
//        $sql="insert into lianxi (id,username,age,sex) values(1,'lili','20','女')";
//        $arr=DB::insert($sql);
//        var_dump($arr);
//    }
    //查询
//    public function select(){
//        $sql="select * from lianxi";
//        $bool=DB::select($sql);
//        print_r($bool);
//    }
    //删除
//    public function del(){
//        $sql="delete from lianxi where id=1";
//        $bool=DB::delete($sql);
//        var_dump($bool);
//    }
    //修改
//    public function update(){
//        $sql="update lianxi set age=12 where id=1";
//        $bool=DB::update($sql);
//        var_dump($bool);
//    }
}
