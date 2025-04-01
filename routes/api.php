<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Hash;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/test', function () {
    $allData = User::all();
    return response()->json(['message' => $allData, 'status' => 200]);
});

Route::get('/test/{id}', function ($id) {
    $data = User::find($id);
    return response()->json(['message' => $data, 'status' => 200]);
});

Route::delete('/deleteTest/{id}', function ($id) {
    $item = User::find($id);
    $item->delete();
    return 'done delete';
});

Route::delete('/deleteTest', function () {
    $data = User::all();
    $data->delete();
    return response()->json(['message' => 'done delete', 'status' => 200]);
});


Route::put('/updateTest/{id}', function ($id,Request $request) {
    try {
        $data = User::find($id);
        $data->name = $request->input("name");
        $data->email = $request->input("email");
        $data->save();
        return response()->json(['message' => 'done'.$data , 'status' => 200]);
    } catch (Exception $e) {
        return response()->json(['message' => 'error', 'status' => 500]);
    };
});


Route::post('/test', function (Request $request) {
    $name = $request->input("name");
    $email = $request->input("email");
    $password = $request->input("password");
    $value = User::create([
        'name' => $name,
        'email' => $email,
        'password' => bcrypt($password),
    ]);
    return response()->json([
        'message' => 'User created successfully',
        'user' => $value,
    ]);
});




Route::post('/register', function (Request $request) {
    $name = $request->input("name");
    $email = $request->input("email");
    $password = $request->input("password");
    $value = User::create([
        'name' => $name,
        'email' => $email,
        'password' => bcrypt($password),
    ]);
    return response()->json([
        'message' => 'User created successfully',
        'user' => $value,
    ]);
});



Route::post('/login', function (Request $request) {
   $user=User::where('email',$request->input('email'))->first();


   if(!$user){
    return response()->json(['message'=>'user not found'],401);
   }

   if(!Hash::check($request->input('password'),$user->password)){
    return response()->json(['message'=>'password not match'],401);
   }

   $token=$user->createToken('auth_token')->plainTextToken;
    return response()->json(['message'=>'login successfully','token'=>$token],200);

});