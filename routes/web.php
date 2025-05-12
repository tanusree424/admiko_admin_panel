<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Purchaseorders\PurchaseordersController;





Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

  
});
