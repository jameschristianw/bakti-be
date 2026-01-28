<?php


use App\Http\Controllers\SermonController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Sermon endpoints
    Route::get('/sermons/latest', [SermonController::class, 'latest']);
    Route::get('/sermons', [SermonController::class, 'index']);
    Route::get('/sermons/{identifier}', [SermonController::class, 'show']);
});
