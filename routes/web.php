<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/chat', [ChatController::class, 'getMessages']);
Route::post('/send-message', [ChatController::class, 'sendMessage']);

Route::get('/auction', [ChatController::class, 'auction']);
Route::post('/auction-submit', [ChatController::class, 'SetAuction']);