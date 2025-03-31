<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/test', function (Request $request) {
    return 'Hello World';
});
Route::post('/test', function (Request $request) {
    $name = $request->input("name");
    $email = $request->input("email");
    $password = $request->input("password");
    $value= User::create([
        'name' => $name,
        'email' => $email,
        'password' => bcrypt($password),
    ]);
    return response()->json([
        'message' => 'User created successfully',
        'user' => $value,
    ]);
});
