<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Salesreports**/
/**Salesreports**/
Route::delete("salesreports/destroy", [Salesreports\SalesreportsController::class,"destroy"])->name("salesreports.delete");
Route::resource("salesreports", Salesreports\SalesreportsController::class)->parameters(["salesreports" => "salesreports_id"])->names("salesreports")->except(["show"])->whereNumber("salesreports_id");