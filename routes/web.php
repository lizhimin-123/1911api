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

Route::get('/', function () {
    return view('welcome');
});
Route::any('/test',"TestController@Test"); 
Route::any('/getWxToken',"TestController@getWxToken"); 
Route::any('/getWxToken2',"TestController@getWxToken2"); 
Route::any('/token',"TestController@getAccessToken"); 
Route::any('/user/info',"TestController@userInfo");

Route::any('/test2',"TestController@test2");


Route::post('/reg',"LoginController@reg");
Route::post('/login',"LoginController@login");
Route::get('/center',"LoginController@center")->middleware('verify.token','count');

Route::get('/test1',"TestController@test1");

Route::get('/aes1',"TestController@aes1");
Route::any('/dec',"TestController@dec");
Route::get('/rsa1',"TestController@rsa1");

Route::get('/aesdec',"TestController@aesdec");
Route::get('/test/sing1','TestController@sing1');

Route::get('/testpay','TestController@pay');

Route::get('/pay','TestController@testpay');
 