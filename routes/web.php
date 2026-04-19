<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('signup');
});

Route::get('signup', function () {
    return view('signup');
});

Route::get('login', function () {
    return view('login');
});
Route::get('dashboard', function () {
    return view('dashboard');
});
Route::get('mining', function () {
    return view('mining');
});
Route::get('withdraw', function () {
    return view('withdraw');
});

