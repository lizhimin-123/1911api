<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Login;
use App\TokenModel;
use Illuminate\Support\Str;
class LoginController extends Controller
{
    /**
     * 注册
     * @return [type] [description]
     */
    public function reg()
    {
    	$data=[
    		'user_name'=>request()->input('user_name'), 
    		'user_email'=>request()->input('user_email'),
    		'user_pwd'=>password_hash(request()->input('user_pwd'),PASSWORD_BCRYPT),    	  
    		'user_pwd2'=>request()->input('user_pwd2'),

    		'create_time'=>time()
    	]; 

    	$res = Login::create($data);
    	$response = [
    		'errno'=>0,
    		'msg'=>'ok'
    	];
    	return $response;

    }

    public function login()
    {
    	$user_name = request()->input('user_name');    	   
    	$user_pwd = request()->input('user_pwd');
    	//验证登录信息
    	$res = Login::where(['user_name'=>$user_name])->first();
    	if($res)
    	{

    		//验证密码
    		if (password_verify($user_pwd,$res->user_pwd)) {
    			//生成token
    			$token = Str::random(32);
    			$expire_seconds = 3600; //token有效期

    			$data = [
    				'token'=> $token,
    				'u_id' =>$res->user_id,
    				'expire_at' =>time() + $expire_seconds
    			];

    			//入库
    			//
    			$tid = TokenModel::insert($data);
       			$response = [
    			'error' => 0,
    			'msg' => 'ok',
    			'data'=>[
    				'token' => $token,
    				'expire_in' => $expire_seconds
    			]
    		];
    			


    		}else{
    			$response = [
    			'error' => 500001,
    			'msg' => '密码错误'
    		];
    		}
    		
    	}else{
    		$response = [
    			'error'=> 400001,
    			'msg' => '用户不存在'
    		];
    	}
    		return $response;


    }

    public function center()
    {
        $token = request()->get('token');
        //验证token是否有效
        $to = TokenModel::where(['token'=>$token])->first();
    	$user_info = Login::find($to->u_id);
    	$response = [
    			'error' =>0,
    			'msg' => 'ok',
    			'data' => [
    				'user_info'=> $user_info
    			]
    		];
			return $response;

    }

}
