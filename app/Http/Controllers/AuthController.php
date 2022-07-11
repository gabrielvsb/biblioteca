<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    const ROLE_READER = 'reader';

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $role = Role::findByName(self::ROLE_READER);
        $user->assignRole($role->id);

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'usuario' => [
                'nome' => $user->name,
                'email' => $user->email
            ],
            'token' => $token
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Não foi possível realizar a autenticação'], 400);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['message' => 'Autenticação realizada com sucesso!', 'token' => $token]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }
}
