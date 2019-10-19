<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $rules = [
        'name' => 'required',
        'password' => 'required',
        'email' => 'required|email|unique:users,email',
        // 'username' => 'required|unique:users,username',
        ];

        $messages = [
        'name.required' => 'Name is required',
        'password.required' => 'Password is required',
        'email.required' => 'Email is required',
        'email.unique' => 'This email is already registered with us',
        // 'username.required' => 'Username is required',
        ];

        $this->validate($request, $rules, $messages);

        $user = User::create([
             'name'    => $request->name,
             'username'    => $request->username,
             'email'    => $request->email,
             'phone'    => $request->phone,
             'password' => $request->password,
         ]);

        $request->role_ids = [2];

        $user->syncRoles($request->role_ids);

        return redirect('users');

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user' 		   => auth()->user()
        ]);
    }
}