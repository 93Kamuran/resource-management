<?php

use App\Http\Controllers\HtmlSnippetController;
use App\Http\Controllers\PdfResourceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'pdf-resources'], static function () {
    Route::post('/', [PdfResourceController::class, 'store']);
    Route::post('/{pdfResource}', [PdfResourceController::class, 'update']);
    Route::get('/', [PdfResourceController::class, 'index']);
    Route::delete('/{pdfResource}', [PdfResourceController::class, 'destroy']);
    Route::get('/{pdfResource}/download', [PdfResourceController::class, 'download']);
});
Route::group(['prefix' => 'html-snippets'], static function () {
    Route::post('/', [HtmlSnippetController::class, 'store']);
    Route::put('/{htmlSnippet}', [HtmlSnippetController::class, 'update']);
    Route::delete('/{htmlSnippet}', [HtmlSnippetController::class, 'destroy']);
    Route::get('/', [HtmlSnippetController::class, 'index']);
});
