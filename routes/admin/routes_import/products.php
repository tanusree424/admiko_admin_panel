<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Products**/
/**Products**/
Route::delete("products/destroy", [Products\ProductsControllerExtended::class,"destroy"])->name("products.delete");
Route::resource("products", Products\ProductsControllerExtended::class)->parameters(["products" => "products_id"])->names("products")->except(["show"])->whereNumber("products_id");