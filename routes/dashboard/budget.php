<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Dashboard\Budget\Ramification\{
    Index as BudgetRamification

};
use App\Livewire\Dashboard\Budget\Account\{
    Index as BudgetAccount

};

Route::prefix('dashboard/budget/ramification')->middleware(['auth'])->group(function () {
    Route::get('/', BudgetRamification::class)->name('dashboard.ramification.index');
});
Route::prefix('dashboard/budget/account')->middleware(['auth'])->group(function () {
    Route::get('/', BudgetAccount::class)->name('dashboard.account.index');
});
