<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**ProductStockA**/
/**ProductStockA**/
Route::get("product-stock-a/product-1-auto-complete", [ProductStockA\ProductStockAControllerExtended::class,"product_1_auto_complete"])->name("product_stock_a.product_1_auto_complete");
Route::delete("product-stock-a/destroy", [ProductStockA\ProductStockAControllerExtended::class,"destroy"])->name("product_stock_a.delete");
Route::resource("product-stock-a", ProductStockA\ProductStockAControllerExtended::class)->parameters(["product-stock-a" => "product_stock_a_id"])->names("product_stock_a")->except(["show"])->whereNumber("product_stock_a_id");