<?php

use App\Livewire\Dashboard\Bidding\{
    Index,
    Create,
    Details,
    Edit,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('dashboard/bidding')->middleware(['auth'])->group(function () {
    Route::get('/', Index::class)->name('dashboard.bidding.index');
    Route::get('/create', Create::class)->name('dashboard.bidding.create');
    Route::get('/{id}/details', Details::class)->name('dashboard.bidding.details');
    Route::get('/{id}/edit', Edit::class)->name('dashboard.bidding.edit');
});



