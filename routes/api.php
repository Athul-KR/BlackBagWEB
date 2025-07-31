<?php 
// routes/api.php

use App\Http\Controllers\SocketrequestController;
use App\Http\Controllers\VideotranscribeController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;
Route::post('socketrequest',[SocketrequestController::class, 'handleWSSEvent']);
Route::post('videotranscribe',[VideotranscribeController::class, 'handleEvent']);
Route::get('/smartmeter/fulfillments', [WebhookController::class, 'smartMeterFulfillments']);
Route::post('/smartmeter/fulfillments', [WebhookController::class, 'smartMeterFulfillments']);
Route::get('/smartmeter/get_fulfillments', [WebhookController::class, 'getFulfillments']);
Route::post('/smartmeter/get_fulfillments', [WebhookController::class, 'getFulfillments']);
Route::post('/smartmeter/readings', [WebhookController::class, 'smartMeterFetchdata']);
Route::get('/smartmeter/readings', [WebhookController::class, 'smartMeterFetchdata']);

Route::get('/dosespot/notifications', [WebhookController::class, 'dosespotNotifications'])->name('dosespotNotifications');
Route::post('/dosespot/notifications', [WebhookController::class, 'dosespotNotifications'])->name('dosespotNotifications');



