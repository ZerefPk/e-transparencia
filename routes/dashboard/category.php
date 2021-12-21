<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\Category\{
    Index
};

Route::prefix('dashboard/category')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.category.index');
});
