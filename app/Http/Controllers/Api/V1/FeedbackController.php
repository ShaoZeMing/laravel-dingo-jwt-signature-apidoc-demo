<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Repositories\FeedbackRepositoryEloquent;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FeedbackCreateRequest;
use App\Http\Requests\FeedbackUpdateRequest;
use App\Repositories\FeedbackRepository;
use App\Validators\FeedbackValidator;

/**
 * Class FeedbackController.
 *
 * @package namespace App\Http\Controllers;
 */
class FeedbackController extends Controller
{
    /**
     * @var FeedbackRepository
     */
    protected $repository;

    /**
     * @var FeedbackValidator
     */
    protected $validator;

    /**
     * FeedbackController constructor.
     *
     * @param FeedbackRepository $repository
     * @param FeedbackValidator $validator
     */
    public function __construct(FeedbackRepositoryEloquent $repository, FeedbackValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * @api {post} /api/v1/user/feedback 用户反馈
     * @apiDescription 用户注册，邮箱和用户名不能重复吗
     * @apiGroup Feedback
     * @apiPermission jwt
     * @apiParam {string} contact 联系方式
     * @apiParam {string} content 反馈内容
     * @apiUse jwt
     * @apiUse sign
     * @apiUse Success
     * @apiSampleRequest /api/v1/user/feedback
     * @apiVersion 1.0.0
     */
    public function feedback(FeedbackCreateRequest $request)
    {
        try {

            $user = $this->getUser();
            $data = [
                'user_id' => $user->id,
                'client_type' => $request->get('device_os'),
                'contact' => $request->get('contact'),
                'content' => $request->get('content'),
            ];
            $feedback = $this->repository->create($data);
            Log::info('用户反馈', [$feedback,$user, __METHOD__]);
            return $this->responseJson(0, 'success');
        } catch (\Exception $e) {
            Log::error($e, [__METHOD__]);
            return $this->responseJson(3001, $e->getMessage());
        }
    }


}
