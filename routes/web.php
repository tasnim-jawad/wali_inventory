<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return view('app');
// });

Route::get('/login', function () {
    return view('Auth.login');
})->name('login');
