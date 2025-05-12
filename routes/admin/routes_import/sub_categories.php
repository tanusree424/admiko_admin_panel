<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Categories**/
/**Categories**/
Route::delete("sub_categories/destroy", [SubCategories\SubCategoriesControllerExtended::class,"destroy"])->name("sub_categories.delete");
Route::resource("sub_categories", SubCategories\SubCategoriesControllerExtended::class)->parameters(["sub_categories" => "sub_categories_id"])->names("sub_categories")->except(["show"])->whereNumber("sub_categories_id");