<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Admin\CatController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
       require __DIR__ . '/cat.php';
       require __DIR__ . '/subcat.php';
    });
});
