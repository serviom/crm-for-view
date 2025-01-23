<?php

namespace App\Http\Controllers\Auth\Email;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use App\Services\Auth\LoginService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $loginService;
    protected $user;

    public function __construct( LoginService $loginService, User $user )
    {
        $this->loginService = $loginService;
        $this->user = $user;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        return $this->loginService->login($request->validated());
    }

    public function logout()
    {
        auth("api")->logout(true);

        return response()->json([
            'message' => 'Successfully logged out.',
            'status' => 'success'
        ], 200);
    }

    public function me()
    {
        $user = $this->user->getItem(Auth::guard()->user()->getAuthIdentifier());

        return response()->json([
            "data" => new UserResource($user)
        ],200);
    }

    public function refresh()
    {
        return $this->loginService->refresh();
    }
}
