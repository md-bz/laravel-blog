<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string'],
            'c_password' => ['required', 'same:password'],
        ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $token =  $user->createToken($data['email'])->plainTextToken;

        return response()->json(
            [
                'success' => true,
                'token' => $token,
                'message' => 'User register successfully.'
            ]
        );
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid email or password.']);
        }
        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'message' => 'User login successfully.'
        ]);
    }
}
