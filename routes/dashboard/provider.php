<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\Provider\{
    Index
};

Route::prefix('dashboard/provider')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.provider.index');
});
