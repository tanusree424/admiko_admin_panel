<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Categories**/
/**Categories**/
Route::delete("categories/destroy", [Categories\CategoriesController::class,"destroy"])->name("categories.delete");
Route::resource("categories", Categories\CategoriesController::class)->parameters(["categories" => "categories_id"])->names("categories")->except(["show"])->whereNumber("categories_id");