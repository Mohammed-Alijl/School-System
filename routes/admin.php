<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin', 'throttle:admin'])->group(function () {

});
