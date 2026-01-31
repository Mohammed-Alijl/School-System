<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'throttle:admin'])->group(function () {

});

Route::get('/', function () {
    return view('site.welcome');
});
