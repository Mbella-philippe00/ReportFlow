<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $auth,
    ) {}

    /**
     * Authentification.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->auth->login(
                $request->validated('email'),
                $request->validated('password'),
            );
        } catch (ValidationException $exception) {
            Log::channel('security')->warning('auth.login.failed', [
                'email' => $request->validated('email'),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            throw $exception;
        }

        Log::channel('security')->info('auth.login.success', [
            'user_id' => $result['user']->id,
            'email' => $result['user']->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie.',
            'token' => $result['token'],
            'token_type' => 'Bearer',

            'user' => [
                'id' => $result['user']->id,
                'name' => $result['user']->name,
                'email' => $result['user']->email,
                'roles' => $result['user']
                    ->getRoleNames()
                    ->values(),
            ],
        ]);
    }

    /**
     * Déconnexion.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        $this->auth->logout($user);

        Log::channel('security')->info('auth.logout', [
            'user_id' => $user?->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie.',
        ]);
    }

    /**
     * Utilisateur connecté.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('roles', 'employee');

        return response()->json([
            'success' => true,

            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,

                'roles' => $user
                    ->getRoleNames()
                    ->values(),

                'employee' => $user->employee,
            ],
        ]);
    }

    /**
     * Backward-compatible Sanctum user endpoint.
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
