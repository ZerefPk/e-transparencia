<?php

use App\Livewire\Home\Contract\{

    Index,
    Details,
    Statistic

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

Route::prefix('contratos')->group(function () {

    Route::get('/', Index::class)->name('site.contract.index');
    Route::get('/estatisticas', Statistic::class)->name('site.contract.statistic');
    Route::get('/{contract:slug}', Details::class)->name('site.contract.details');



});



