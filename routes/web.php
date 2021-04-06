<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
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

Route::get('/', [CustomerController::class, 'book_ticket_view']);
Route::post('/', [CustomerController::class, 'book_ticket'])->name('book.ticket');

/**
 * Admin actions
 */

Route::group(['prefix'=>'admin'], function(){
    Route::get('events', [AdminController::class, 'events'])->name('events');
    Route::post('events', [AdminController::class, 'create_event'])->name('create.event');
    Route::get('delete-event/{id}', [AdminController::class, 'delete_event'])->name('delete.event');

    Route::get('tickets', [AdminController::class, 'tickets'])->name('tickets');
    Route::post('tickets', [AdminController::class, 'set_ticket_cost'])->name('update.ticket');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
