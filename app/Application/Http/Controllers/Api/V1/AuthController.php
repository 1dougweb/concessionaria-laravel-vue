<?php

namespace App\Application\Http\Controllers\Api\V1;

use App\Application\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function profile(): JsonResponse
    {
        return response()->json(auth('api')->user());
    }

    public function logout(Request $request): JsonResponse
    {
        JWTAuth::invalidate($request->bearerToken());

        return response()->json(['message' => 'Logged out']);
    }

    private function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'refresh_ttl' => config('jwt.refresh_ttl') * 60,
            'user' => auth('api')->user(),
        ]);
    }
}

