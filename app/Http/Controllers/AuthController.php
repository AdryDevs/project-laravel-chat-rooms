<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    const SUPER_ADMIN_ROLE = 1;
    const ADMIN_ROLE = 2;
    const USER_ROLE = 3;

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->messages(),
            ], 400);
        }

        $user = User::create([
            'name'=> $request->get('name'),
            'email'=> $request->get('email'),
            'password'=> bcrypt($request->get('password')),
            'password2'=> bcrypt($request->get('password2')),
        ]);

            if('password' !== 'password2'){

                return response()->json([
                    'success' => false,
                    'message' => 'Passwords do not match',
                ], 400);
            }



        $user->roles()->attach(self::USER_ROLE);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
        
    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $input = $request->only('email', 'password');

        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'user' => $user
        ], 200);
    }

    public function logout(Request $request) {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function profile(){

        return response()->json(
            [
                'user' => auth()->user(),
                'roles' => auth()->user()->roles
            ]
        );
    }
}
