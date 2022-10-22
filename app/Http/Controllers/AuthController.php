<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Auth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|',
            'username' => 'required|string|unique:users,username|min:5',
            'password' => 'required|string|min:5'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors()->toJson(), 400);
        }
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'admin'
        ];
        $user = User::create($data);
        return response()->json([
            'message' => 'User created successfully.',
            'user' => $user,
        ], 200);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors()->toJson(), 422);
        }

        if (!$token = auth()->attempt($validate->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL()*60*24,
            'user' => auth()->user()
        ]);
    }

    public function profile()
    {

        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }
    public function logout()
    {
        return response()->json([
            'message' => 'User logout.',
        ]);
    }
}
