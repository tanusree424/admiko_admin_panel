<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Userloginsession**/
/**Userloginsession**/
Route::delete("userloginsession/destroy", [Userloginsession\UserloginsessionController::class,"destroy"])->name("userloginsession.delete");
Route::resource("userloginsession", Userloginsession\UserloginsessionController::class)->parameters(["userloginsession" => "userloginsession_id"])->names("userloginsession")->except(["show"])->whereNumber("userloginsession_id");