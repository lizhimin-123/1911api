<?php

namespace App\Http\Middleware;

use Closure;
use App\TokenModel;
class VerifyAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token = request()->get('token');
        //var_dump($token);
        if(empty($token))
        {
            $response = [
                'error' =>400003,
                'msg' => '未授权'
            ];
            return response()->json($response);
           ;
        }
        //验证token是否有效
        $to = TokenModel::where(['token'=>$token])->first();
        // var_dump($to);
        if(empty($to))
        {
                $response = [
                'error' =>400003,
                'msg' => 'token无效'
            ];
            return response()->json($response);
        }

       
        return $next($request);
    }
}
