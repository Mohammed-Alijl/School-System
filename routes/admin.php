<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:admin'])->group(function () {

    Route::get('/', function () { return view('admin.index');});
    Route::get("/{page}", [DashboardController::class, "index"])->name("admin.page");
});
