<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\Outlay\Effort\{
    Index as Effort,
    Create as EffortCreate,
};

Route::prefix('dashboard/effort')->middleware(['auth'])->group(function () {
    Route::get('/', Effort::class)->name('dashboard.effort.index');
    Route::get('/create', EffortCreate::class)->name('dashboard.effort.create');
});
