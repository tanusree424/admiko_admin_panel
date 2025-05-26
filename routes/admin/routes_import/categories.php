<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Categories**/

Route::get("categories/categories-auto-complete", [categories\CategoriesControllerExtended::class,"categories_auto_complete"])->name("categories.categories_auto_complete");


Route::delete("categories/destroy", [Categories\CategoriesControllerExtended::class,"destroy"])->name("categories.delete");
Route::resource("categories", Categories\CategoriesControllerExtended::class)->parameters(["categories" =>"categories_id"])->names("categories")->except(["show"])->whereNumber("categories_id");

