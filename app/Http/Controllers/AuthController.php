<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if (User::where('email', '=', $request->email)->exists()) {
            return response()->json(
                array(
                    'error' => 'Email Exists'
                )
                );
         }

        $user = User::create([
             'email'    => $request->email,
             'password' => $request->password,
             'name' => $request->name
         ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token, $request->email);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['success'=> false,'error' => 'Unauthorized']);
        }

        return $this->respondWithToken($token, $credentials['email']);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token, $email)
    {
        $user = User::where('email', '=', $email)->get();

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        //return $request->password;
        //$s1 = Hash::make('1234')
        $user->password = $request->password;
        $user->setRememberToken(Str::random(60));

        $user->save();

        return response()->json(
            array(
                'success'=> true
            )
        );
    }
}
