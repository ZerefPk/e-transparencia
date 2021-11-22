<?php

use App\Http\Livewire\Home\Bidding\{
    Statistic,
    Index,
    Others
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

Route::prefix('licitacao')->group(function () {
    Route::get('/{data?}', Index::class)->name('site.bidding.index');
    Route::get('{year}/estatisticas', Statistic::class)->name('site.bidding.statistic');
    Route::get('link/outros', Others::class)->name('site.bidding.others');

});



