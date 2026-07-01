<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $result = $this->auth->login(
            $request->validated('email'),
            $request->validated('password'),
        );

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
        $this->auth->logout($request->user());

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
}
