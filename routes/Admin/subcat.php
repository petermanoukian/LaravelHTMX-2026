<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SubcatController;


Route::get('subcat/index/{catid?}', [SubcatController::class, 'index'])->name('subcat.index');
Route::match(['get', 'post'], 'subcat/json/{catid?}', [SubcatController::class, 'indexJson'])->name('subcat.indexJson');


// Add validation
Route::match(['get', 'post'], 'subcat/validate-name', [SubcatController::class, 'validateNameAdd'])
    ->name('subcat.validateNameAdd');

// Update validation
Route::match(['get', 'post', 'put'], 'subcat/validate-name-update', [SubcatController::class, 'validateNameUpdate'])
    ->name('subcat.validateNameUpdate');


Route::get('subcat/create/{catid?}', [SubcatController::class, 'create'])->name('subcat.create');
Route::post('subcat/store', [SubcatController::class, 'store'])->name('subcat.store');


Route::get('subcat/{id}/show', [SubcatController::class, 'show'])->name('subcat.show');
Route::get('subcat/edit/{id}', [SubcatController::class, 'edit'])->name('subcat.edit');
Route::put('subcat/{subcat}', [SubcatController::class, 'update'])->name('subcat.update');


Route::delete('subcat/{subcat}', [SubcatController::class, 'destroy'])->name('subcat.destroy');
Route::match(['post','delete'], 'subcat/destroy-all/destroyall', [SubcatController::class, 'destroyAll'])->name('subcat.destroyAll');
