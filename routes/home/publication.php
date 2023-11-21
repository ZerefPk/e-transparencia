<?php

use App\Livewire\Home\Publication\{

    Index,

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

Route::prefix('publicacoes')->group(function () {

    Route::get('/{publication}', Index::class)->name('site.publication.index');


});



