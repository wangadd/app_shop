<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('index','IndexController@index');
Route::get('register','user\RegisterController@register');//注册视图
Route::post('doadd','user\RegisterController@doadd');//注册执行
Route::get('login','user\RegisterController@login');//登录视图
Route::post('dologin','user\RegisterController@dologin');//登录执行
Route::get('index','index\IndexController@index');//首页
Route::post('getcode','user\RegisterController@getcode');//发送短信验证码
Route::any('detail','index\IndexController@detail');//商品详情页
Route::any('content','index\IndexController@detail');//商品详情页
Route::post('goodsli','index\IndexController@addli');//流加载

Route::any('allshops','goods\GoodsController@allshops');//商品分类
Route::any('shopsli','goods\GoodsController@shopsli');//商品分类

Route::any('cart','cart\CartController@cart');//购物车列表
Route::any('addcart','cart\CartController@addcart');//加入购物车
Route::any('del','cart\CartController@del');//逻辑删除

Route::any('payment','cart\PayController@payment');//去结算
Route::any('payshow','cart\PayController@payshow');//去结算
Route::any('payaddress','cart\PayController@payaddress');//
Route::post('address','cart\PayController@address');//添加收货地址
Route::any('addressshow','cart\PayController@addressshow');//展示收货地址
Route::any('deladdress','cart\PayController@deladdress');//删除收货地址
Route::any('edit','cart\PayController@edit');//修改收货地址
Route::any('edit_do','cart\PayController@edit_do');//修改收货地址
Route::any('checked','cart\PayController@checked');//修改收货地址

Route::any('getGoodsNum','cart\CartController@getGoodsNum');//判断库存  点击加号
Route::any('min','cart\CartController@min');//判断库存  点击减号
Route::post('deleteAll','cart\CartController@deleteAll');//批量删除
Route::post('getNum','cart\CartController@getNum');
Route::get('userprofile','cart\RecordController@userprofile');//我的潮购
Route::get('userPage','cart\RecordController@userPage');//潮购记录

Route::any('show','showController@show');//缓存  搜索，分页

//基本路由
//Route::get('do',function(){
//    return 222;
//});
////路由映射控制器
//Route::get('show','OrderController@show');
////路由显示视图
//Route::get('add',function(){
//    return view('show');
//});
////路由重定向百度
//Route::get('demo/{id}',function($id){
//    if($id < 2){
//        return redirect('http://www.baidu.com');
//    }else{
//        return 1111;
//    }
//});
////路由名称前缀
//Route::prefix('admin')->group(function () {
//    Route::get('show', function () {
//        echo 111111;
//    });
//    Route::get('msg','OrderController@msg');
//});
//Route::get('list1','OrderController@list1');
//Route::get('doadd','GoController@add');
//Route::get('del','GoController@del');
//Route::get('update','GoController@update');
//Route::get('select','GoController@select');
//Route::get('form','GoController@add');
//Route::post('doadd','GoController@doadd');
//Route::get('show','GoController@show');
//Route::post('del','GoController@del');
//Route::get('update','GoController@update');
//Route::post('update_do','GoController@update_do');
//Route::post('upd','GoController@upd');





Route::any('test','TestController@test');