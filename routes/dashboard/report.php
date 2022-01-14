<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\Report\{
    Index,
    Management
};

Route::prefix('dashboard/report')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.report.index');
    Route::get('{id}/management', Management::class)->name('dashboard.report.management');
});
