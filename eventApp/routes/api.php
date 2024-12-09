<?php

// use App\Http\Controllers\AdminController;
// use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Route::apiResource('customers', CustomerController::class);
//Route::apiResource('invoices', InvoiceController::class);
// Route::apiResource('admins', AdminController::class);
//Route::apiResource('members', MemberController::class);
//Route::apiResource('events', EventController::class);

Route::controller(MemberController::class)->group(function () {
   Route::post('/register', 'store');
   Route::post('/login', 'login');
   Route::get('/auth-user', 'index')->middleware('auth:api');
   Route::post('logout', 'logout')->middleware('auth:api');
});
Route::controller(EventController::class)->group(function () {
    Route::get('/events', 'index')->middleware('auth:api');
});
Route::controller(InvoiceController::class)->group(function () {
    Route::get('/invoices', 'index')->middleware('auth:api');
});



//Route::middleware('auth:api')->get('/members', [MemberController::class, 'showInfo']);

/* Route::post('login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json(['token' => $token], 200);
    } else {
        return response()->json(['error' => 'Unauthorized!'], 401);
    }
});
Route::middleware('auth:api')->get('/members', [MemberController::class, 'show']); */


