<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**AdminUsers**/
/**AdminUsers**/
Route::delete("admin-users/destroy", [AdminUsers\AdminUsersController::class,"destroy"])->name("admin_users.delete");
Route::resource("admin-users", AdminUsers\AdminUsersController::class)->parameters(["admin-users" => "admin_users_id"])->names("admin_users")->except(["show"])->whereNumber("admin_users_id");