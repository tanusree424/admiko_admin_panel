<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Brands**/
/**Brands**/
Route::delete("brands/destroy", [Brands\BrandsController::class,"destroy"])->name("brands.delete");
Route::resource("brands", Brands\BrandsController::class)->parameters(["brands" => "brands_id"])->names("brands")->except(["show"])->whereNumber("brands_id");