<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Repositories\ClientRepository;
use App\Repositories\UpgradeRepositoryEloquent;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class AuthController
 * User: ZeMing Shao
 * Email: szm19920426@gmail.com
 * @package App\Http\Controllers\Api\V1_0_0
 */
class UpgradesController extends Controller
{


    /**
     * @api {get} /api/v1/upgrade APP升级
     * @apiDescription 请求接口判断是否需要升级
     * @apiGroup APP
     * @apiPermission sign
     * @apiUse sign
     * @apiUse Success
     * @apiSampleRequest /api/v1/upgrade
     * @apiVersion 1.0.0
     */
    public function upgrade(Request $request, UpgradeRepositoryEloquent $upgradeRepository)
    {
        try {
            $appVer = $request->get('app_ver');
            $clientType = $request->get('device_os');
            $where = [
                'client_type' => $clientType,
            ];
            $res = $upgradeRepository->getLatestByWhere($where, $appVer);
            Log::info('升级接口数据', [$res,$clientType,$appVer, __METHOD__]);
            if($res){
                return $this->responseJson(0, 'success', $res);
            }
            return $this->responseJson(0, 'success');
        } catch (\Exception $e) {
            Log::error($e, [__METHOD__]);
            return $this->responseJson(3001, $e->getMessage());
        }
    }



}
