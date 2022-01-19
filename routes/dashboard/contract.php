<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\Contract\{
    Create,
    Index
};

Route::prefix('dashboard/contract')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.contract.index');
    Route::get('/create', Create::class)->name('dashboard.contract.create');
});
