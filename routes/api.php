<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadScheduleFileController;
use App\Http\Controllers\ContactListController;
use App\Http\Controllers\ChangeNotificationController;

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

Route::prefix('contacts')->group(function () {
    Route::post('/upload', UploadScheduleFileController::class);
    Route::get('/', ContactListController::class);
    Route::put('/{id}', ChangeNotificationController::class)->whereNumber('id');

//    Route::get('/', function () {
//        $useCae = new \App\UseCases\NotifyContactUseCase();
//        $useCae->notify();
//    });
});
