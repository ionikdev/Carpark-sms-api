<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Carpark;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    use HttpResponses;



    public function register(RegisterRequest $request){
        $request->validated($request->all());

        $user = User::create([
            'username' => $request ->username,
            'phone' => $request ->phone,
            'email' => $request ->email,
            'password'=>Hash::make($request->password),
            'role' => $request->role,
        ]);
            return $this->success([
                'user'=> $user,
                'token'=> $user->createToken('API Token of '. $user->name)->plainTextToken,

            ], "Registration Was successful", 200);
    }

    // User login

    public function login(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user role is 'user' (or any other role as needed)
            if ($user->role === 'user') {
                $token =  $user->createToken('API Token of '. $user->name)->plainTextToken;

                return $this->success([
                    'user' => $user,
                    'token' => $token,
                ], 'Login successful', 200);
            }

            return $this->error('Unauthorize User Access', 401);
        }

        return $this->error('Unauthorize Access', 401);
    } catch (\Exception $e) {
        return $this->error('Something went wrong', 500);
    }
}

// Operator Login
    public function operatorLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $this->isOperator($user)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('API Token of '. $user->name)->plainTextToken;

                return $this->success([
                    'user' => $user,
                    'token' => $token,
                ], 'Operator Login successful', 200);
            }
        }

        return $this->error('Unauthorize User Access', 401);
    }
// Admin Login
    private function isOperator($user)
    {
        return $user->role === 'operator';
    }


    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $this->isAdmin($user)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('API Token of '. $user->name)->plainTextToken;

                return $this->success([
                    'user' => $user,
                    'token' => $token,
                ], 'Admin Login successful', 200);
            }
        }

        return $this->error('Unauthorize User Access', 401);
    }

    private function isAdmin($user)
    {
        return $user->role === 'admin';
    }

    public function logout(Request $request)
{
    try {
        $request->user()->currentAccessToken()->delete();

        return $this->success([], 'Logged out successfully', 200);
    } catch (\Exception $e) {
        return $this->error('Something went wrong', 500);
    }
}





}
