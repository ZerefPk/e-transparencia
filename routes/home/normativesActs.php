<?php

use App\Http\Livewire\Home\NormativeAct\{

    Index,
    AdvancedQuery,

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

Route::prefix('atos-normativos')->group(function () {

    Route::get('/consulta-avancada', AdvancedQuery::class)->name('site.normativeact.advancedQuery');
    Route::get('/{typeNormativeAct:slug}', Index::class)->name('site.normativeact.index');


});



