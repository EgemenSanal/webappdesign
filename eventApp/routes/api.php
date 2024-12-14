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
   Route::post('/register', 'register');
   Route::post('/login', 'login');
   Route::get('/user', 'index')->middleware('auth:api');
   Route::get('user/{id}', [MemberController::class, 'show'])->middleware('auth:api');
   Route::post('logout', 'logout')->middleware('auth:api');
   Route::put('user/{member}', 'update')->middleware('auth:api');
   Route::patch('user/{member}', 'update')->middleware('auth:api');
   Route::delete('user/{member}', 'destroy')->middleware('auth:api');

});
Route::controller(EventController::class)->group(function () {
    Route::get('/events', 'index');
    Route::get('/events/{id}', 'showevent');
    Route::put('/events/{event}', 'update')->middleware('auth:api');
    Route::patch('/events/{event}', 'update')->middleware('auth:api');
    Route::post('/createEvent', 'store');
    Route::delete('/events/{event}', 'destroy')->middleware('auth:api');
});
Route::controller(InvoiceController::class)->group(function () {
    Route::get('/invoices', 'index')->middleware('auth:api');
    Route::post('/invoices', 'store')->middleware('auth:api');
    Route::get('/invoices/{id}', 'show')->middleware('auth:api');
    Route::put('/invoices/{invoice}', 'update')->middleware('auth:api');
    Route::patch('/invoices/{invoice}', 'update')->middleware('auth:api');
    Route::delete('/invoices/{invoice}', 'destroy')->middleware('auth:api');
});


