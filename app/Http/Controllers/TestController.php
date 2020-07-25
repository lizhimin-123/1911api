<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class TestController extends Controller
{
    //
    public function Test()
    {
    	$appid = "wx70b42c1d1a4ee5b4";
    	$appsecret = "5c52d652cce1d40cd1a438374def34bf";
    	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
    	$data = file_get_contents($url);
    	echo $data;
    }

    public  function getWxToken()
    {

    	$appid = "wx70b42c1d1a4ee5b4";
    	$appsecret = "5c52d652cce1d40cd1a438374def34bf";
    	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
    	// 创建一个新cURL资源
		$ch = curl_init();

		// 设置URL和相应的选项
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//返回结果通过变量接收
		// 抓取URL并把它传递给浏览器
		$response = curl_exec($ch);

		// 关闭cURL资源，并且释放系统资源
		curl_close($ch);
		echo $response;
    }

    public function getWxToken2()
    {
    	$appid = "wx70b42c1d1a4ee5b4";
    	$appsecret = "5c52d652cce1d40cd1a438374def34bf";
    	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
    	$client = new Client();
    	$response = $client->request('GET',$url);
    	$response = $client->request('GET',$url)->getBody();
    	echo $response;

    }

    public function getAccessToken()
    {
    	$token = Str::random(32);
    	$data = [
    		'token' => $token,
    		'expire_in' => 7200
    	];
    	echo json_encode($data);
    }

    public function userInfo()
    {
        echo 123;
    }
    public function test2()
    {
        echo Str::random(30);
    }

    public function test1()
    {
        echo __METHOD__;
    }





    //对称加密
    public function aes1()
    {
        $data = 'Hello World';//原始数据
        $method = 'AES-256-CBC'; //加密算法
        $key = '1911api'; //加密秘钥
        $iv = "aaaaaabbbbbbcccc";//初始化 iv cbc加密方式 16位

        echo '加密前原文: '.$data;echo '</br>';

        $enc_data = openssl_encrypt($data, $method, $key,OPENSSL_RAW_DATA,$iv);
        var_dump($enc_data);
        echo '加密后的密文: '.$enc_data;echo '</br>';

        echo "<hr>";

        //对称解密
        $dec_data = openssl_decrypt($enc_data, $method,$key,OPENSSL_RAW_DATA,$iv);
        echo '解密数据: '.$dec_data;

    }
    /**
     * 对称解密
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    // public function dec(Request $request)
    // {
    //     $method = 'AES-256-CBC';
    //     $key = '1911api';
    //     $iv = 'aaaaaabbbbbbcccc';
    //     $option = OPENSSL_RAW_DATA;

    //     //$str1 = $request->post('data');//收到的加密数据
    //     //$content = file_get_contents("php://input"); //接收post 原始数据
    //     echo '<pre>';print_r($_POST);echo '</pre>';echo '</br>';
    //     //echo 'str1: '.$str1;echo '</br>';
    //     $enc_data = base64_decode($_POST['data']);
    //     //echo '密文: '.$str2;echo '</br>';

    //     //$enc_data = $request->post('data'); 

    //     //解密数据
    //     $dec_data = openssl_decrypt($enc_data,$method,$key,OPENSSL_RAW_DATA,$iv);
    //     //var_dump($dec_data);
    //     echo '解密数据: '.$dec_data;


    // }
    

    //对称解密
    public function dec(Request $request){
        $method='AES-256-CBC';
        $key='1911api';
        $iv='aaaaaabbbbcccccc';
        $option=OPENSSL_RAW_DATA;

        //$content=file_get_contents("php://input");
        echo '<pre>';print_r($_POST);echo '</pre>';echo "</br>";; 
        //echo $content;die;
        $enc_data=base64_decode($_POST['data']);
        
        //解密
        $dec_data=openssl_decrypt($enc_data, $method, $key,$option,$iv);
        echo "解密数据: ". $dec_data;

    }

     //非对称 私钥解密
   public function rsa1(){
        echo 123;
        $priv_key=openssl_get_privatekey(file_get_contents(storage_path('keys/priv.key')));
        openssl_private_decrypt($enc_data,$dec_data,$priv_key);
        echo '解密: '.$dec_data;
    }
    
    public function aesdec()
    {
        //将加密数据发给对方
        
        $pub_key = openssl_get_privatekey(file_get_contents(storage_path('keys/pub.key')));
        openssl_public_encrypt($enc_data, $pub_key);

        echo '解密: '.$dec_data;
    }

    public function sing1(Request $request)
    {

        $key = '1911api';   //计算签名key
        //接收数据
            $data = $request->get('data');
            $sign = $request->get('sign'); //接收签名

            //计算
            $sign_str1 = md5($data . $key); //接收端计算的签名

            if($sign_str1 == $sign)
            {
                echo '验签通过';
            }else{
                echo '验签失败';
            }
    }





}
