<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@gate');


//Member Controller
Route::get('register', 'MemberController@showRegistrationForm')->name('register.get');
Route::get('register/token={token}')->name('register.sendtoken');
Route::post('register', 'MemberController@register')->name('register.post');

