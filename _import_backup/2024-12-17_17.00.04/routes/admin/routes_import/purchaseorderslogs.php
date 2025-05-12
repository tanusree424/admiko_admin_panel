<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Purchaseorderslogs**/
/**Purchaseorderslogs**/
Route::delete("purchaseorderslogs/destroy", [Purchaseorderslogs\PurchaseorderslogsController::class,"destroy"])->name("purchaseorderslogs.delete");
Route::resource("purchaseorderslogs", Purchaseorderslogs\PurchaseorderslogsController::class)->parameters(["purchaseorderslogs" => "purchaseorderslogs_id"])->names("purchaseorderslogs")->except(["show"])->whereNumber("purchaseorderslogs_id");