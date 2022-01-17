<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\Publication\{
    Index,
    Management
};

Route::prefix('dashboard/publication')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.publication.index');
    Route::get('{id}/management', Management::class)->name('dashboard.publication.management');
});
