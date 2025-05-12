<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Purchaseorders**/
/**Purchaseorders**/
Route::delete("purchaseorders/destroy", [Purchaseorders\PurchaseordersController::class,"destroy"])->name("purchaseorders.delete");
Route::resource("purchaseorders", Purchaseorders\PurchaseordersController::class)->parameters(["purchaseorders" => "purchaseorders_id"])->names("purchaseorders")->except(["show"])->whereNumber("purchaseorders_id");