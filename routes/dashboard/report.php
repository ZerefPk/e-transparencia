<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\Report\{
    Index
};

Route::prefix('dashboard/report')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.report.index');
});
