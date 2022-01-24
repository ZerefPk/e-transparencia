<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\Budget\Ramification\{
    Index as BudgetRamification

};

Route::prefix('dashboard/budget/ramification')->middleware(['auth'])->group(function () {
    Route::get('/', BudgetRamification::class)->name('dashboard.ramification.index');
});
