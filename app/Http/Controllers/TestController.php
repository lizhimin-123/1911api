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
        $id = $_SERVER['HTTP_UID'];
        $tokne = $_SERVER['HTTP_TOKEN'];
        
        if(isset($_SERVER['HTTP_TOKEN']))
        {

        }else{
            echo '授权失败';die;
        }

        $id = $SERVER['HTTP_UID'];
        $tokne = $_SERVER['HTTP_TOKEN'];

        echo 'uid: '.$uid;echo '</br>';
        echo 'token: '.$token;echo '</br>';
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

    public function pay()
    {
        return view('/pay');
    }

     /**
     * 跳转支付宝支付
     */
    public function testpay(Request $request)
    {
        $oid = $request->get('oid');
        //echo '订单ID： '. $oid;
        //根据订单查询到订单信息  订单号  订单金额

        //调用 支付宝支付接口

        // 1 请求参数
        $param2 = [
            'out_trade_no'      => time().mt_rand(11111,99999),
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
            'total_amount'      => 0.01,
            'subject'           => '1911-测试订单-'.Str::random(16),
        ];

        // 2 公共参数
        $param1 = [
            'app_id'        => '2016100100643318',
            'method'        => 'alipay.trade.page.pay',
            'return_url'    => 'http://apilzm.lwei.xyz/return',   //同步通知地址
            'charset'       => 'utf-8',
            'sign_type'     => 'RSA2',
            'timestamp'     => date('Y-m-d H:i:s'),
            'version'       => '1.0',
            'notify_url'    => 'http://apilzm.lwei.xyz/notify',   // 异步通知
            'biz_content'   => json_encode($param2),
        ];

        //echo '<pre>';print_r($param1);echo '</pre>';
        // 计算签名
        ksort($param1);
        //echo '<pre>';print_r($param1);echo '</pre>';

        $str = "";
        foreach($param1 as $k=>$v)
        {
            $str .= $k . '=' . $v . '&';
        }

        $str = rtrim($str,'&');     // 拼接待签名的字符串

        $sign = $this->sign($str);
        echo $sign;echo '<hr>';

        //沙箱测试地址
        $url = 'https://openapi.alipaydev.com/gateway.do?'.$str.'&sign='.urlencode($sign);
        return redirect($url);
        //echo $url;
    }

    protected function sign($data)
    {
//        if ($this->checkEmpty($this->rsaPrivateKeyFilePath)) {
//            $priKey = $this->rsaPrivateKey;
//
//            $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
//                wordwrap($priKey, 64, "\n", true) .
//                "\n-----END RSA PRIVATE KEY-----";
//        } else {
//            $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
//            $res = openssl_get_privatekey($priKey);
//        }

        $priKey = file_get_contents(storage_path('key/ali_priv.key'));
        $res = openssl_get_privatekey($priKey);
        var_dump($res);echo '<hr>';

        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }



}
