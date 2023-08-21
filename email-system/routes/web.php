<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\MailController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::get('/addUserForm', function () {
//     return view('register');
// })->name('addUserForm');

// Route::get('/abc', function () {
//     return view('abc');
// });

// Route::get('/mailForm', function () {
//     return view('mailForm');
// })->name('mailForm');
Route::controller(UserController::class)->group(function(){
    Route::get('home','sessionCheck')->name('home');
//     Route::post('/add','addUsers')->name('addUsers');
//     Route::get('/updateUserForm','updateUserForm')->name('update.user.form');
//     Route::post('/updateUser','updateUser')->name('update.user');
//     Route::post('/Login','validateLogin')->name('login');
//     Route::get('/logout','logout')->name('logout');
});
// Route::controller(MailController::class)->group(function(){
//     Route::post('/send_mail','send_mail')->name('send_mail');
//     Route::get('/sent_mail','sent_mail')->name('sent_mail');
//     Route::get('/','dashboard');
//     Route::get('/mail_details/{id}','mailDetails')->name('mail.details');
//     Route::get('/sentmail_details/{id}','sentMailDetails')->name('sentmail.details');
// });


