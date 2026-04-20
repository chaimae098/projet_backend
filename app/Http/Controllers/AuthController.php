<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request) {
    $data = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required|in:candidat,recruteur'
    ]);
    $data['password'] = bcrypt($data['password']);
    $user = User::create($data);
    $token = auth()->login($user);
    return response()->json(['token' => $token, 'user' => $user], 201);
}

public function login(Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    if (!$token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    return response()->json(['token' => $token, 'user' => auth()->user()]);
}

public function logout() {
    auth()->logout();
    return response()->json(['message' => 'Logged out']);
}

public function me() {
    return response()->json(auth()->user());
}

}
