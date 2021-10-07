<?php

use App\Http\Controllers\PdfResourceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'pdf-resources'], static function () {
    Route::post('/', [PdfResourceController::class, 'store']);
    Route::post('/{pdfResource}', [PdfResourceController::class, 'update']);
    Route::get('/', [PdfResourceController::class, 'index']);
    Route::delete('/{pdfResource}', [PdfResourceController::class, 'destroy']);
    Route::get('/{pdfResource}/download', [PdfResourceController::class, 'download']);
});
