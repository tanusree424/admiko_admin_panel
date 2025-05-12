<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Productstock**/
/**Productstock**/
Route::delete("productstock/destroy", [Productstock\ProductstockController::class,"destroy"])->name("productstock.delete");
Route::resource("productstock", Productstock\ProductstockController::class)->parameters(["productstock" => "productstock_id"])->names("productstock")->except(["show"])->whereNumber("productstock_id");