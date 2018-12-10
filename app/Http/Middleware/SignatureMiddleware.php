<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Liyu\Signature\Facade\Signature;

class SignatureMiddleware
{


    /**
     * User: ZeMing Shao
     * Email: szm19920426@gmail.com
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $this->verify($request);
            return $next($request);
        } catch (\Exception $e) {
            Log::error($e, [__METHOD__]);
            if (!$request->expectsJson()) {
                return redirect(route('login'));
            } else {
                $output = [
                    'error' => $e->getCode(),
                    'msg' => $e->getMessage(),
                ];
                return response()->json($output);
            }
//
        }

    }


    /**
     * User: ZeMing Shao
     * Email: szm19920426@gmail.com
     * @param Request $request
     * @throws \Exception
     */
    public function verify(Request $request)
    {
        $data = $request->all();
        $timestamp = $request->get('timestamp') ?: 0;
        $time = time();
        $timeout = config('signature.timeout', 60);

        Log::info('验签：', [$timestamp, $time, $timeout, $data, __METHOD__]);

        if (($time - $timestamp) > $timeout) {
            throw new \Exception('签名过期', 1002);
        }

        $app_id = config('signature.app_id.' . $request->get('app_id'));
        if (!$app_id) {
            throw new \Exception('app_id not find', 1003);
        }

        $key = config('signature.app_id.' . $request->get('app_id'));
        $sign = $data['sign'];
        unset($data['sign']);
        if (!(Signature::setKey($key)->verify($sign, $data))) {
            throw new \Exception('签名错误', 1001);
        }
    }


}
