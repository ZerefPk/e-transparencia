<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Dashboard\Contract\{
    Create,
    Edit,
    Index,
    Details
};

Route::prefix('dashboard/contract')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.contract.index');
    Route::get('/create', Create::class)->name('dashboard.contract.create');
    Route::get('{contract:id}/details', Details::class)->name('dashboard.contract.details');
    Route::get('{contract:id}/edit', Edit::class)->name('dashboard.contract.edit');
});
