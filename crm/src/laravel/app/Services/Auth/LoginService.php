<?php
namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class LoginService
{

    /**
     * Get a JWT via given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($data)
    {
        $credentials = collect($data)->toArray();
        $user = User::onlyTrashed()->where('email', $credentials['email'])->first();

        if ($user) {
            return response()->json([
                'message' => 'Користувач з таким email є в базі але був видалений!!!',
                'status' => 'error'
            ], 400);
        }

        $user = $this->getUser($credentials);


        if (!$user) {
            return response()->json([
                'message' => 'Невірний логін чи пароль',
                'status' => 'error'
            ], 400);
        }

        $roleName = count($user->getRoleNames()) ? $user->getRoleNames()[0] : null;

        if ($token = auth("api")->claims(['roleName' => $roleName])->attempt($credentials)) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }

        return response()->json([
            'message' => 'Помилка авторизації',
            'status' => 'error'
        ], 400);
    }

    public function refresh () {
        try {
            $oldToken = JWTAuth::getToken();
            if (!$oldToken) {
                return response()->json([
                    'message' => 'Error refresh token.',
                    'status' => 'error'
                ], 401);
            }
            $payload = JWTAuth::manager()->getJWTProvider()->decode($oldToken->get());
            $user = User::find($payload['sub']);
            if (!$user) {
//                Log::info(date('Y-m-d H:m:s') . '- $payload=' . collect($payload));
                return response()->json([
                    'message' => 'Error refresh token.',
                ], 401);
            }
            if (($token = auth('api')->refresh()) ) {//TODO: логіка надання доступу
                return response()->json([
                    'message' => 'Successfully refresh token. ',
                ], 200)
                    ->header('Authorization', $token);
            }
            return response()->json([
                'message' => 'Error refresh token.',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error refresh token.',
            ], 401);
        }
    }

    private function getUser ($credentials)
    {
        $user = User::where("email", $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user;
        }

        return null;
    }
}
