<?php

use App\Http\Livewire\Home\Contract\{

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

Route::prefix('contrato')->group(function () {

    Route::get('/', Index::class)->name('site.contract.index');


});



