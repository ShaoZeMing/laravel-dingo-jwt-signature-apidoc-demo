<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Log;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,Helpers;




    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $error
     * @param $msg
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJson($error, $msg, $data = null)
    {
        $output = [
            'error' => $error,
            'msg'   => $msg,
        ];
        if (!is_null($data)) {
            $output['data'] = $data;
        }
        return \response()->json($output);
    }


    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param \Exception $ex
     * @param $code
     * @param $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function ex_response( \Exception $ex, $code, $msg)
    {
        $code = $ex->getCode() ? $ex->getCode() : $code;
        $msg = $ex->getMessage() ? $ex->getMessage() : $msg;

        $output = [
            'error' => $code,
            'msg'   => $msg,
        ];
        return \response()->json($output);
    }



    /**
     * 获取app登陆user
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @throws \Exception
     */
    public function getUser($guards='api')
    {
        try {
            $user = auth($guards)->user();
            Log::info('获取登录用户',[$user,$guards,__METHOD__]);
            if ($user) {
                return $user;
            }
            Log::error('登陆过期',[$user,$guards,__METHOD__]);
            throw new \Exception('登录过期', 1000);
        } catch (\Exception $ex) {
            Log::error($ex);
            throw new \Exception('登录过期', 1000);
        }
    }
}
