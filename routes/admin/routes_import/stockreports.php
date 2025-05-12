<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Stockreports**/
/**Stockreports**/
Route::delete("stockreports/destroy", [Stockreports\StockreportsControllerExtended::class,"destroy"])->name("stockreports.delete");
Route::resource("stockreports", Stockreports\StockreportsControllerExtended::class)->parameters(["stockreports" => "stockreports_id"])->names("stockreports")->except(["show"])->whereNumber("stockreports_id");
Route::get('/stockreports/{id}', [Stockreports\StockreportsController::class, 'showSummary']);

Route::get('/stockreports/exportExcel/{id}', [Stockreports\StockreportsController::class, 'exportExcel']);
Route::post('/stockreports/delete/{id}', [Stockreports\StockreportsController::class, 'deleteStockReport']);
Route::post('/stockreports/confirm/{id}', [Stockreports\StockreportsController::class, 'confirmOrder']);