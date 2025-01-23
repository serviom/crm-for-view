<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUsersRequest;
use App\Http\Requests\Users\DeleteUsersRequest;
use App\Http\Requests\Users\UpdateUsersRequest;
use App\Http\Requests\Users\RestoreUsersRequest;
use App\Http\Requests\Users\UsersRequest;
use App\Http\Requests\Users\GetUsersRequest;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Auth\AllRolesResource;
use App\Models\User;
use App\Services\Users\UsersService;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class UsersController extends Controller
{
    protected $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index(GetUsersRequest $request)
    {
        if(auth()->user()->hasRole('SuperAdmin')
            || auth()->user()->hasPermissionTo('users.viewAny')
            || auth()->user()->hasPermissionTo('users.viewMyOnly')
        ) {
            if(auth()->user()->hasPermissionTo('users.viewMyOnly')){
                $request['senior_agent_id'] = auth()->user()->id;
            }

            $result = $this->usersService->getItems($request);

            return response()->json([
                'data' => UserResource::collection($result['data']),
                'count' => $result['count']
            ], 200);
        }

        abort(403);
    }

    public function show(UsersRequest $request, $userId)
    {
        $this->authorize('view', $this->usersService->getItem($userId));

        $data = $this->usersService->getItem($userId);

        return response()->json(
            new UserResource($data)
        );
    }

    public function store(CreateUsersRequest $request)
    {
        $this->authorize('create', User::class);

        $user = User::onlyTrashed()->where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'errors' => [
                    'email' => 'Користувач був видалений ' . $user->deleted_at->format('d.m.Y') . '.',
                ],
                'status' => 'user_archive',
                'userId' => $user->id
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ],[
            'email.unique' => 'Вказаний email вже використовується',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $data = $this->usersService->createItem($request);

        return response()->json([
            'message' => 'Користувач успішно створений',
            'data' => new UserResource($data),
        ], 200);
    }

    public function restore(RestoreUsersRequest $request, $userId)
    {
        $this->authorize('restore', User::class);

        $data = $this->usersService->restoreUser($userId);

        if ($data) {
            return response()->json([
                'message' => 'Користувача відновлено!'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Цього користувача неможливо відновити',
            ], 409);
        }
    }


    public function update(UpdateUsersRequest $request, $userId)
    {
        $this->authorize('update', $this->usersService->getItem($userId));

        $data = $this->usersService->updateItem($userId, $request);

        if ($data) {
            return response()->json([
                'message' => 'Користувач успішно оновлений',
                'data' => new UserResource($data),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Цього користувача неможливо редагувати',
            ], 409);
        }
    }

    public function destroy(DeleteUsersRequest $request, $userId)
    {
        $this->authorize('delete', $this->usersService->getItem($userId));

        $data = $this->usersService->deleteItem($userId, $request);

        if ($data) {
            return response()->json([
                'message' => 'Користувач успішно видалений',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Цього користувача неможливо видалити',
            ], 409);
        }
    }

    public function allRolesList (Request $request) {
        $this->authorize('viewAny', User::class);

        $result = $this->usersService->getAllRolesList();

        return response()->json([
            'data' => AllRolesResource::collection($result),
        ], 200);
    }

    public function logList(UsersRequest $request)
    {
        $result = $this->usersService->getLogList($request->user_id);

        return response()->json([
            'data' => $result,
        ], 200);
    }
}
