<?php

namespace App\Units\Auth\Http\Controllers;

use App\Support\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public function login(Request $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $request->validate([
            'email'         => 'required|string|email',
            'password'      => 'required|string',
            'remember_me'   => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        try {
            if (! $token = app('tymon.jwt.auth')->attempt($credentials)) {

                $this->incrementLoginAttempts($request);
                return response()->json(['error' => 'invalid_credentials'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            $this->incrementLoginAttempts($request);
            return response()->json(['error' => 'could_not_create_token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respondWithToken($token);
    }

    public function username()
    {
        return 'email';
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]);

        return response()->json(['error' => $message ], Response::HTTP_TOO_MANY_REQUESTS);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
