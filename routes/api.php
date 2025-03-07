<?php

use App\Http\Controllers\GuestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('guests')->name('guests.')->group(function () {
    Route::post('/', [GuestController::class, 'store'])->name('store');
    Route::get('/{guest}', [GuestController::class, 'show'])->name('show');
    Route::put('/{guest}', [GuestController::class, 'update'])->name('update');
    Route::delete('/{guest}', [GuestController::class, 'destroy'])->name('destroy');
});
