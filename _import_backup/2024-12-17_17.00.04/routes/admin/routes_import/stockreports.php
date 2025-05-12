<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Stockreports**/
/**Stockreports**/
Route::delete("stockreports/destroy", [Stockreports\StockreportsController::class,"destroy"])->name("stockreports.delete");
Route::resource("stockreports", Stockreports\StockreportsController::class)->parameters(["stockreports" => "stockreports_id"])->names("stockreports")->except(["show"])->whereNumber("stockreports_id");