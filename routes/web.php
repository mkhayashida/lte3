<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/demo123', function () {
    return view('demo2');
});


Route::get('/pigu-snow-white/e11c7907cfaec1a9a836770dae8ab1eb', function () {
    return view('pigu-snow-white');
});

Route::get('/jackpot', [ApiController::class, 'jackpot'])
    ->name('jackpot');

Route::get('/rank', [ApiController::class, 'rank'])
    ->name('rank');