<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\SystemWidePartsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/import-parts', [ExcelImportController::class, 'importExcel']);
Route::get('/system-wide-parts', [SystemWidePartsController::class, 'index']);




