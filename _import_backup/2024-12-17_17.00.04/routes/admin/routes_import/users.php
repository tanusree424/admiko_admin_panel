<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Users**/
/**Users**/
Route::delete("users/destroy", [Users\UsersController::class,"destroy"])->name("users.delete");
Route::resource("users", Users\UsersController::class)->parameters(["users" => "users_id"])->names("users")->except(["show"])->whereNumber("users_id");