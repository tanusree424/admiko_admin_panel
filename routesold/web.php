<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Purchaseorders\PurchaseordersController;
use App\Http\Controllers\Admin\SubCategories\SubCategoriesController;




Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
   Route::get('/sub_categories/{id}', [SubCategoriesController::class,"editSubCategories"])->name('admin.edit.subcategories');
  
});


// Route::resource('sub_categories', SubCategoriesControllerExtended::class)
//     ->parameters(['sub_categories' => 'sub_categories_id'])
//     ->names('sub_categories')
//     ->except(['show'])
//     ->whereNumber('sub_categories_id');