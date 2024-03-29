<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedUser = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'middle_name' => '',
                'email' => 'required|unique:users|email',
                "password" => 'required|confirmed|min:6'

            ]);

            if ($validatedUser->fails()) {
                return Response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validatedUser->errors()
                ], 401);
            }

            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);


            User_data::create([
                'name' => $request->name,
                'user_id' => $user->id,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name
            ]);

            return Response()->json([
                'status' => true,
                'message' => 'User created!',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (Throwable $th) {
            return Response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validatedUser = Validator::make($request->all(), [
                'email' => 'required|email',
                "password" => 'required'

            ]);

            if ($validatedUser->fails()) {
                return response()->json([
                    'stauts' => false,
                    'message' => 'Validation error',
                    'errors' => $validatedUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'stauts' => false,
                    'message' => 'Email and Password do not match',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (Throwable $th) {
            return Response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            Auth::user()->currentAccessToken()->delete();

            return Response()->json([
                'status' => true,
                'message' => "Successful logout!"
            ], 200);

        } catch (Throwable $th) {
            return Response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function getUser()
    {
        $token = request()->bearerToken();
        $userToken = PersonalAccessToken::findToken($token);
        $user = $userToken->tokenable;

        return response()->json([
            'status' => true,
            'data' => User_data::where('user_id', $user->id)->first()
        ], 200);
    }
}
