<?php

use App\Http\Controllers\EditTempController;
use App\Http\Livewire\Dashboard\Bidding\Edit;
use App\Http\Livewire\Dashboard\HomeDashboard;
use App\Http\Livewire\Home\Index;
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

Route::get('/', Index::class)->name('home.index');

Route::get('/dashboard', HomeDashboard::class)->middleware(['auth'])->name('dashboard');

Route::get('/replace', [EditTempController::class, 'update']);
require __DIR__.'/auth.php';
require __DIR__.'/dashboard/bidding.php';

require __DIR__.'/home/bidding.php';
