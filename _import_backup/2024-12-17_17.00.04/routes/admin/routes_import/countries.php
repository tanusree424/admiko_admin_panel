<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Countries**/
/**Countries**/
Route::delete("countries/destroy", [Countries\CountriesController::class,"destroy"])->name("countries.delete");
Route::resource("countries", Countries\CountriesController::class)->parameters(["countries" => "countries_id"])->names("countries")->except(["show"])->whereNumber("countries_id");