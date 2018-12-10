<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }


    /**
     * User: ZeMing Shao
     * Email: szm19920426@gmail.com
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param mixed ...$guards
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
            return $next($request);
        } catch (\Exception $e) {
            Log::info('登录验证失败', [$guards,$request->header(),__METHOD__]);
            Log::error($e, [__METHOD__]);
            if (!$request->expectsJson() && array_first($guards) != 'api') {
                Log::info('登录验证失败跳转', [__METHOD__]);
                return redirect(route('login'));
            } else {
                $output = [
                    'error' => 1000,
                    'msg' => '登录过期',
                ];
                return response()->json($output);
            }
        }

    }


}
