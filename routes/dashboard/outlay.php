<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Dashboard\Outlay\Effort\{
    Index as Effort,
    Create as EffortCreate,
    Edit as EffortEdit,
};

Route::prefix('dashboard/effort')->middleware(['auth'])->group(function () {
    Route::get('/', Effort::class)->name('dashboard.effort.index');
    Route::get('/create', EffortCreate::class)->name('dashboard.effort.create');
    Route::get('{effort:id}/edit', EffortEdit::class)->name('dashboard.effort.edit');
});
