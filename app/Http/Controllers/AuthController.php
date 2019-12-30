<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Get a JWT token via given credentials.
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = Auth::guard()->attempt($credentials)) {
            return response(['status' => 'success'])
                ->header('Authorization', $token);
        }

        return response(['error' => 'Unauthorized'], 401);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if(isset($user)) return response($user, 201);

        return response([
            'status' => 'error',
            'error' => 'invalid.credentials',
            'msg' => 'Invalid Credentials.'
        ], 400);
    }

    /**
     * Get the authenticated User
     * @return Response
     */
    public function user()
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Log the user out (Invalidate the token)
     * @return Response
     */
    public function logout()
    {
        Auth::guard()->logout();
        return response(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     * @return Response
     */
    public function refresh()
    {
        $token = (Auth::guard()->refresh());
        return response(['status' => 'success'])->header('Authorization', $token);
    }
}
