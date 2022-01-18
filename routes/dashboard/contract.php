<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\Contract\{
    Index
};

Route::prefix('dashboard/contract')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.contract.index');
});
