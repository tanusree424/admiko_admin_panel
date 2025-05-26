<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**ProductCountryMapping**/
/**ProductCountryMapping**/
Route::get("product-country-mapping/products-auto-complete", [ProductCountryMapping\ProductCountryMappingControllerExtended::class,"products_auto_complete"])->name("product_country_mapping.products_auto_complete");
Route::get("product-country-mapping/country-auto-complete", [ProductCountryMapping\ProductCountryMappingControllerExtended::class,"country_auto_complete"])->name("product_country_mapping.country_auto_complete");
Route::delete("product-country-mapping/destroy", [ProductCountryMapping\ProductCountryMappingControllerExtended::class,"destroy"])->name("product_country_mapping.delete");
Route::resource("product-country-mapping", ProductCountryMapping\ProductCountryMappingControllerExtended::class)->parameters(["product-country-mapping" => "product_country_mapping_id"])->names("product_country_mapping")->except(["show"])->whereNumber("product_country_mapping_id");