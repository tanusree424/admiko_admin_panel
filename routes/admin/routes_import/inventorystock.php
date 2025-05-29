<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**InventoryStock**/
/**InventoryStock**/
// Route::post('/inventorystocks/delete', [InventoryStock\InventorystockControllerExtended::class, 'destroy'])
//     ->name('admin.inventorystock.delete');

Route::delete("inventorystocks/destroy", [InventInventoryStock\InventorystockControllerExtended::class,"destroy"])->name("inventorystock.delete");
Route::resource("inventorystocks", InventoryStock\InventorystockControllerExtended::class)->parameters(["inventorystock" => "inventorystock_id"])->names("inventorystock")->except(["show"])->whereNumber("InventoryStock_id");

Route::get('/inventorystocks/{id}', [InventoryStock\InventorystockController::class, 'showSummary']);

Route::get('/inventorystocks/exportExcel/{id}', [InventoryStock\InventorystockController::class, 'exportExcel']);
Route::get('/inventorystocks/exportPdf/{orderId}/{userId}', [InventoryStock\InventorystockController::class, 'exportPdf']);
Route::post('/inventorystocks/delete/{id}', [InventoryStock\InventorystockController::class, 'deleteIS']);
Route::post('/inventorystocks/confirm/{id}', [InventoryStock\InventorystockController::class, 'confirmOrder']);

