<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Purchaseorders**/
/**Purchaseorders**/
Route::delete("purchaseorders/destroy", [Purchaseorders\PurchaseordersControllerExtended::class,"destroy"])->name("purchaseorders.delete");
Route::resource("purchaseorders", Purchaseorders\PurchaseordersControllerExtended::class)->parameters(["purchaseorders" => "purchaseorders_id"])->names("purchaseorders")->except(["show"])->whereNumber("purchaseorders_id");

Route::get('/purchaseorders/{id}', [Purchaseorders\PurchaseordersController::class, 'showSummary']);

Route::get('/purchaseorders/exportExcel/{id}', [Purchaseorders\PurchaseordersController::class, 'exportExcel']);
Route::get('/purchaseorders/exportPdf/{orderId}/{userId}', [Purchaseorders\PurchaseordersController::class, 'exportPdf']);
Route::post('/purchaseorders/delete/{id}', [Purchaseorders\PurchaseordersController::class, 'deletePo']);
Route::post('/purchaseorders/confirm/{id}', [Purchaseorders\PurchaseordersController::class, 'confirmOrder']);

 