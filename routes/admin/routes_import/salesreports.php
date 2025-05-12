<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Salesreports**/
/**Salesreports**/
Route::delete("salesreports/destroy", [Salesreports\SalesreportsControllerExtended::class,"destroy"])->name("salesreports.delete");
Route::resource("salesreports", Salesreports\SalesreportsControllerExtended::class)->parameters(["salesreports" => "salesreports_id"])->names("salesreports")->except(["show"])->whereNumber("salesreports_id");

Route::get('/salesreports/{id}', [Salesreports\SalesreportsController::class, 'showSummary']);

Route::get('/salesreports/exportExcel/{id}', [Salesreports\SalesreportsController::class, 'exportExcel']);
// Route::get('/purchaseorders/exportPdf/{orderId}/{userId}', [Purchaseorders\PurchaseordersController::class, 'exportPdf']);
Route::post('/salesreports/delete/{id}', [Salesreports\SalesreportsController::class, 'deleteSalesReport']);
Route::post('/salesreports/confirm/{id}', [Salesreports\SalesreportsController::class, 'confirmOrder']);