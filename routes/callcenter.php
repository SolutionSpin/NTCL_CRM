<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CallcenterController;
use App\Http\Controllers\AgentDashboardController;

/* call center management */
Route::group(['prefix' => 'agent','middleware' => ['agent'] ], function () {
    //agent dashboard
    Route::get('/dashboard', [AgentDashboardController::class, 'dashboard']);

    Route::get('/call-center/all-call', [CallcenterController::class, 'getAllCall']);
    Route::get('/call-center/fatch-all-call', [CallcenterController::class, 'fatch_all_call']);


    Route::get('/call-center/get-garment-data', [CallcenterController::class, 'getGarmentDetails']);
    Route::post('/call-center/store-call-data', [CallcenterController::class, 'store_call_data']);

    //pending call route
    Route::get('/call-center/pending-call', [CallcenterController::class, 'getPendingCall']);
    Route::get('/call-center/fatch-process-call', [CallcenterController::class, 'fatch_process_call']);

    //precessed call route
    Route::get('/call-center/processed-call', [CallcenterController::class, 'getPrecessedCall']);

    //pending QC Visit
    Route::get('/call-center/qc-visit', [CallcenterController::class, 'getPendingQcVisit']);
    Route::post('/call-center/store-qc-visit-data', [CallcenterController::class, 'store_qc_visit_data']);

    //report
    Route::get('/call-center/call-report', [CallcenterController::class, 'getPendingCall']);
});

/* call center management */
Route::group(['prefix' => 'qc','middleware' => ['qc'] ], function () {
    //agent dashboard
    Route::get('/dashboard', [AgentDashboardController::class, 'qcdashboard']);

    //pending QC Visit
    Route::get('/call-center/qc-visit', [CallcenterController::class, 'getPendingQcVisit']);
    Route::post('/call-center/store-qc-visit-data', [CallcenterController::class, 'store_qc_visit_data']);
    Route::get('/call-center/get-garment-data', [CallcenterController::class, 'getGarmentDetails']);
});
