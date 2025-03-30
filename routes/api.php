<?php

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
    return response()->json(['message' => 'Done ' . $name], 200);
});
