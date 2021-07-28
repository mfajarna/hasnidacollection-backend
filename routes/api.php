<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CollectionController;
use App\Http\Controllers\API\LelangController;
use App\Http\Controllers\API\LelangdetailController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\TukarbarangController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('user/photo', [UserController::class, 'updatePhoto']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::get('transaction', [TransactionController::class,'all']);
    Route::get('pastorders', [TransactionController::class, 'getPastOrders']);
    Route::post('transaction/{id}', [TransactionController::class,'update']);
    Route::post('pembayaranPhoto/{id}', [TransactionController::class,'updatePhotoPembayaran']);
    Route::get('fetchTransaksi',[TransactionController::class,'fetch']);
    Route::post('checkout', [TransactionController::class, 'checkout']);
    Route::get('statusTukar', [TransactionController::class,'getStatusTukar']);
    Route::post('updateStatus/{id}', [TransactionController::class, 'updateStatus']);



    Route::post('collection/{id}', [CollectionController::class,'changeStock']);

    Route::post('lelang', [LelangController::class, 'create']);
    Route::get('fetchLelang', [LelangController::class, 'fetch']);
    Route::post('lelang/{id}', [LelangController::class, 'changeStatus']);

    Route::get('dataLelang', [LelangdetailController::class,'all']);
    Route::post('prosesLelang', [LelangdetailController::class, 'prosesLelang']);
    Route::get('getPemenang', [LelangDetailController::class, 'fetch']);

    Route::post('tukarBarang', [TukarbarangController::class,'create']);
    Route::post('buktiBayar/{id}', [TukarbarangController::class,'updateBuktiPhoto']);
    Route::post('statusBarang/{id}', [TukarbarangController::class,'updateStatus']);
    Route::get('fetchBarang', [TukarbarangController::class,'all']);
    Route::get('allBarang', [TukarbarangController::class,'fetch']);

});


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('listUser', [UserController::class, 'all']);
Route::get('collection', [CollectionController::class, 'all']);

