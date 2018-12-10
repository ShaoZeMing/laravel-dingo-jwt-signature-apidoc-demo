<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Api\Controller;

use Dingo\Api\Http\Request;
use Liyu\Signature\Facade\Signature;

/**
 * Class TestController
 * User: ZeMing Shao
 * Email: szm19920426@gmail.com
 * @package App\Http\Controllers\Api\V1_0_0
 */
class TestController extends Controller
{


    /**
     * @api {get} /api/v1/get/sign 获取签名
     * @apiDescription 填写请求参数进行验签获取sign字符串
     * @apiGroup Sign
     * @apiPermission none
     * @apiParam {string} loginName 用户名
     * @apiParam {string} loginPass 密码
     * @apiParam {string} app_id=keyID 验签查找key使用的ID
     * @apiParam {string} timestamp=15232323323 时间搓
     * @apiParam {string} device_os=mac 客户端系统类型 mac windows ipad ios aos
     * @apiParam {string} [app_ver=1.0.0] app当前版本号
     * @apiParam {string} [device_id=b841fbfb972bdf3cc4f3d360] 设备唯一标识号
     * @apiParam {string} [device_ver=IOS 11.0.4] 客户端系统版本号
     * @apiUse Success
     * @apiSampleRequest /api/v1/get/sign
     * @apiVersion 1.0.0
     */
    public function getSign(Request $request){


        $data = $request->all();
        $app_id = config('signature.app_id.'.$request->get('app_id'));
        if(!$app_id){
            return $this->responseJson(1003,'app_id 不存在');
        }

        $key = config('signature.app_id.'.$request->get('app_id'));
        $signature = Signature::setKey($key)->sign($data);
        $data['sign'] = $signature;
        return $this->responseJson(0,'成功',$data);


    }

    /**
     * @api {post} /api/v1/verify/sign 效验签名
     * @apiDescription 效验签名，参数要和获取签名一致
     * @apiGroup Sign
     * @apiPermission sign
     * @apiParam {string} loginName 用户名
     * @apiParam {string} loginPass 密码
     * @apiUse sign
     * @apiUse Success
     * @apiSampleRequest /api/v1/verify/sign
     * @apiVersion 1.0.0
     */
    public function verifySign(Request $request){

        $data = $request->all();
        return $this->responseJson(0,'成功',$data);


    }



}
