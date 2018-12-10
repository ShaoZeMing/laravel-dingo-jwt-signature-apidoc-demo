<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AdminUserCreateRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Repositories\AdminUserRepository;
use App\Validators\AdminUserValidator;

/**
 * Class AdminUsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class AdminUsersController extends Controller
{
    /**
     * @var AdminUserRepository
     */
    protected $repository;

    /**
     * @var AdminUserValidator
     */
    protected $validator;

    /**
     * AdminUsersController constructor.
     *
     * @param AdminUserRepository $repository
     * @param AdminUserValidator $validator
     */
    public function __construct(AdminUserRepository $repository, AdminUserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $adminUsers = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $adminUsers,
            ]);
        }

        return view('adminUsers.index', compact('adminUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdminUserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AdminUserCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $adminUser = $this->repository->create($request->all());

            $response = [
                'message' => 'AdminUser created.',
                'data'    => $adminUser->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $adminUser = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $adminUser,
            ]);
        }

        return view('adminUsers.show', compact('adminUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adminUser = $this->repository->find($id);

        return view('adminUsers.edit', compact('adminUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdminUserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AdminUserUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $adminUser = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'AdminUser updated.',
                'data'    => $adminUser->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'AdminUser deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'AdminUser deleted.');
    }
}
