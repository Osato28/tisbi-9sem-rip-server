<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    function loginByToken(Request $request)
    {
        try {
            $tokenText = $request->input("token");
            $token = PersonalAccessToken::findToken($tokenText);

            if ($token == null) {
                return response()->json(['success' => false, 'data' => [], 'error' => 'Token missing or expired, relogin via /api/user/login_by_pass to create a new token.'], 401);
            }

            /** @var User $user */
            $user = $token->tokenable;

            return response()->json(['success' => true, 'data' => [
                'username' => $user->name,
                'can_write' => $user->edit_privileges == 1 ? true : false
            ], 'error' => '']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [], 'error' => $e->getMessage()], 504);
        }
    }

    function loginByPass(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $authenticated = Auth::attempt($credentials);

        if ($authenticated) {
            $user = $request->user();
            $user->tokens()->where('name', 'API')->delete();
            $token = $user->createToken('API')->plainTextToken;
            return response()->json(['success' => true, 'data' => [
                'username' => $user->name,
                'token' => $token,
                'can_write' => $user->edit_privileges == 1 ? true : false
            ], 'error' => '']);
        }

        return response()->json(['success' => false, 'data' => [], 'error' => 'Failed to authorize.'], 401);
    }
}
