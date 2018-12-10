<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Repositories\UserRepositoryEloquent;
use Dingo\Api\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserCreateRequest;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;

/**
 * Class AuthController
 * User: ZeMing Shao
 * Email: szm19920426@gmail.com
 * @package App\Http\Controllers\Api\V1_0_0
 */
class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * AuthController constructor.
     * @param UserRepositoryEloquent $repository
     * @param UserValidator $validator
     */
    public function __construct(UserRepositoryEloquent $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * @api {post} /api/v1/user/register 用户注册
     * @apiDescription 用户注册，邮箱和用户名不能重复吗
     * @apiGroup Auth
     * @apiPermission sign
     * @apiParam {string} username 用户名
     * @apiParam {string} email 密码
     * @apiParam {string} password 密码
     * @apiUse Success
     * @apiSampleRequest /api/v1/user/register
     * @apiVersion 1.0.0
     */
    public function register(UserCreateRequest $request)
    {
        try {
            Log::info('参数', [$request->all(), __METHOD__]);
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $data = [
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ];
            $user = $this->repository->create($data);
            Log::info('参数', [$user, __METHOD__]);
            return $this->responseJson(0, 'User created', $user->toArray());
        } catch (ValidatorException $e) {
            Log::error($e,[__METHOD__]);
            return $this->responseJson(3001, $e->getMessageBag());
        }
    }


    /**
     * @api {post} /api/v1/user/login 用户登录
     * @apiDescription 用户登录，登录成功后会放回对应的jwt token
     * @apiGroup Auth
     * @apiPermission sign
     * @apiParam {string} username 用户名
     * @apiParam {string} password 密码
     * @apiUse Success
     * @apiSampleRequest /api/v1/user/login
     * @apiVersion 1.0.0
     */
    public function login(Request $request)
    {
        try {
            $username = $request->get('username');
            $password = $request->get('password');

            $user = $this->repository->scopeQuery(function ($query) use ($username) {
                return $query->where('email', $username)->orWhere('username', $username);
            })->first();

            if (!$user) {
                return $this->responseJson(3002, '该用户没有注册');
            }
            $data = [
                'username' => $user->username,
                'password' => $password,
            ];
            if (!$token = auth('api')->attempt($data)) {
                return $this->responseJson(3004, '账号或密码不正确');
            }
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            Log::error($e,[__METHOD__]);
            return $this->ex_response($e, 3003, '登录失败');
        }
    }





    /**
     * @api {get} /api/v1/user/me 账号信息
     * @apiDescription 账号信息，验证jwt 是否有效
     * @apiGroup Auth
     * @apiPermission jwt
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/user/me
     * @apiVersion 1.0.0
     */
    public function me()
    {
        try{
            $user = $this->getUser();
            return $this->responseJson(0, '登录成功', $user);
        }catch (\Exception $e){
            Log::error($e,[__METHOD__]);
            return $this->ex_response($e, 9999, '获取失败');
        }

    }



    /**
     * @api {get} /api/v1/user/refresh 刷新jwt token
     * @apiDescription  刷新jwt token
     * @apiGroup Auth
     * @apiPermission jwt
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/user/refresh
     * @apiVersion 1.0.0
     */
    public function refresh()
    {
        try{
            return $this->respondWithToken(auth('api')->refresh());
        }catch (\Exception $e){
            Log::error($e,[__METHOD__]);
            return $this->ex_response($e, 9999, '获取失败');
        }
    }

    /**
     * @api {post} /api/v1/user/logout 用户登出
     * @apiDescription  用户登出 使令牌token失效。
     * @apiGroup Auth
     * @apiPermission jwt
     * @apiUse jwt
     * @apiUse Success
     * @apiSampleRequest /api/v1/user/logout
     * @apiVersion 1.0.0
     */
    public function logout()
    {
        try{
            auth('api')->invalidate(); //令牌失效
            return $this->responseJson(0,'登录成功');
        }catch (\Exception $e){
            Log::error($e,[__METHOD__]);
            return $this->ex_response($e, 9999, '获取失败');
        }
    }


    /**
     * User: ZeMing Shao
     * Email: szm19920426@gmail.com
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $data = [
            'token_type' => 'Bearer',
            'access_token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
        return $this->responseJson(0, '登录成功', $data);
    }


}
