<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
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
    }
}
