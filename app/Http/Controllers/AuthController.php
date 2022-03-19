<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
// use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function testApiToken(){
        return response()->json([
            'success' => true
        ]);
    }
    public function attemptLogin(Request $request){
        // return $request->all();
        $fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('username', $fields['username'])->first();

        if (! $user || ! Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Username or Password is incorrect!'
            ], 401);
        }else {
            if($user->confirmation_status){
                $token = $user->createToken('myapptoken')->plainTextToken;
                $response = [
                    'token' => $token,
                    'user' => $user
                ];
                return response($response, 200);
            }else {
                return response([
                    'message' => 'Account Needs Confirmation, please contact this email for your account Confirmation: christiandaveabina@gmail.com or you can Contact DILG Region 8 RICTU Unit to confirm your account.'
                ], 401);
            }
        }
        
        // return $user;
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();
        // return $user;
        if (! $user || ! Hash::check($fields['password'], $user->password)) {
           return response([
               'message' => 'Bad Creds'
           ], 401);
        }

        return $user->createToken('myapptoken')->plainTextToken;
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged Out'
        ];

    }

    public function register(Request $request){
        $fieds = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fieds['name'],
            'email' => $fieds['email'],
            'password' => bcrypt($fieds['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }
}
