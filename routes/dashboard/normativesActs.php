<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\NormativeAct\{
    Index,
    Type
};

Route::prefix('dashboard/types-nomative-acts')->middleware(['auth'])->group(function () {
    Route::get('/', Type::class)->name('dashboard.typenomativesacts.index');
});
Route::prefix('dashboard/nomative-acts')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.nomativesacts.index');
});
