<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::delete("location/destroy", [AdminLocation\LocationController::class,"destroy"])->name("location.delete");
Route::resource("location", AdminLocation\LocationController::class)->parameters(["location" => "location_id"])->names("location")->except(["show"])->whereNumber("location_id");
