<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/addUserForms', function () {
    return view('register');
});


Route::get("/inbox",function(){
    return view('dashboard');
});

Route::get('/sent_mail_page',function(){
    return view('sent_mail');
});
Route::get('/sent_mail_details_view',function(){
    return view('sentMailView');
});
Route::get('/mail_view',function(){
    return view('mailView');
});
Route::get('/updateUserFormView',function(){
    return view('updateUserForm');
});

Route::controller(UserController::class)->group(function(){
    Route::get('/home','sessionCheck');
    Route::post('/addUsers','addUsers');
    Route::post('/Login','validateLogin');
    
});

Route::controller(UserController::class)->group(function(){
    Route::get('/updateUserForm','updateUserForm')->middleware('auth:api');
    Route::post('/updateUser','updateUser')->middleware('auth:api');
    Route::get('/logout','logout')->middleware('auth:api');
});

Route::controller(MailController::class)->group(function(){
    Route::post('/send_mail','send_mail')->middleware('auth:api');
    Route::get('/sent_mail','sent_mail')->middleware('auth:api');
    Route::get('/mail_details/{id}','mailDetails')->middleware('auth:api');
    Route::get('/sentmail_details/{id}','sentMailDetails')->middleware('auth:api');
    Route::get('/dashboardData','dashboard')->middleware('auth:api');
});
