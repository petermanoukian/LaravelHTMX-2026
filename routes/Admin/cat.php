<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CatController;

// Cat routes (already wrapped by admin group in index.php)
Route::get('cat', [CatController::class, 'index'])->name('cat.index');
Route::match(['get', 'post'], 'cat/json', [CatController::class, 'indexJson'])->name('cat.indexJson');

Route::match(['get', 'post'], 'cat/validate-name', [CatController::class, 'validateNameAdd'])->name('cat.validateNameAdd');
Route::match(['get', 'post', 'put'], 'cat/validate-name-update/{id}', [CatController::class, 'validateNameUpdate'])
    ->name('cat.validateNameUpdate');


Route::get('cat/create', [CatController::class, 'create'])->name('cat.create');
Route::post('cat/store', [CatController::class, 'store'])->name('cat.store');

Route::get('cat/{id}', [CatController::class, 'show'])->name('cat.show');
Route::get('cat/{cat}/edit', [CatController::class, 'edit'])->name('cat.edit');
Route::put('cat/{cat}', [CatController::class, 'update'])->name('cat.update');

Route::delete('cat/{cat}', [CatController::class, 'destroy'])->name('cat.destroy');
Route::match(['post', 'delete'], 'cat/destroy-all/destoryall', [CatController::class, 'destroyAll'])->name('cat.destroyAll');
