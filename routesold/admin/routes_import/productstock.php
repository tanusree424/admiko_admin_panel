<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Productstock**/
/**Productstock**/
Route::get("productstock/product-1-auto-complete", [Productstock\ProductstockControllerExtended::class,"product_1_auto_complete"])->name("productstock.product_1_auto_complete");
Route::get("productstock/country-auto-complete", [Productstock\ProductstockControllerExtended::class,"country_auto_complete"])->name("productstock.country_auto_complete");
Route::delete("productstock/destroy", [Productstock\ProductstockControllerExtended::class,"destroy"])->name("productstock.delete");
Route::resource("productstock", Productstock\ProductstockControllerExtended::class)->parameters(["productstock" => "productstock_id"])->names("productstock")->except(["show"])->whereNumber("productstock_id");