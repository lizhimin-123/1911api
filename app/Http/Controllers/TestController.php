<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

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
}
