<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Repositories\ClientRepositoryEloquent;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ClientCreateRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Repositories\ClientRepository;
use App\Validators\ClientValidator;

/**
 * Class ClientsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ClientsController extends Controller
{
    /**
     * @var ClientRepository
     */
    protected $repository;

    /**
     * @var ClientValidator
     */
    protected $validator;

    /**
     * ClientsController constructor.
     *
     * @param ClientRepository $repository
     * @param ClientValidator $validator
     */
    public function __construct(ClientRepositoryEloquent $repository, ClientValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }



    /**
     * @api {get} /api/v1/send/client/info 客户端信息提交
     * @apiDescription 启动应用时候若有网络就提交一次设备信息
     * @apiGroup APP
     * @apiPermission sign
     * @apiParam {string} client_id   客户端唯一编号
     * @apiUse sign
     * @apiUse Success
     * @apiSampleRequest /api/v1/send/client/info
     * @apiVersion 1.0.0
     */
    public function store(ClientCreateRequest $request)
    {
        try {

            $appVer = $request->get('app_ver');
            $clientType = $request->get('device_os');
            $clientId = $request->get('client_id');
            $data = [
                'client_type' => $clientType,
                'version' => $appVer,
                'client_id' => $clientId,
            ];

            $res = $this->repository->create($data);
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
