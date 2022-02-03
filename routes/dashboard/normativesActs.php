<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\NormativeAct\{
    Create,
    Details,
    Index,
    Type
};

Route::prefix('dashboard/types-nomative-acts')->middleware(['auth'])->group(function () {
    Route::get('/', Type::class)->name('dashboard.typenomativesacts.index');
});
Route::prefix('dashboard/nomative-acts')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.nomativesacts.index');
    Route::get('/create', Create::class)->name('dashboard.nomativesacts.create');
    Route::get('{id}/details', Details::class)->name('dashboard.nomativesacts.details');
});
