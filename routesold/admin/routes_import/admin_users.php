<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**AdminUsers**/
/**AdminUsers**/
Route::get("admin-users/country-auto-complete", [AdminUsers\AdminUsersController::class,"country_auto_complete"])->name("admin_users.country_auto_complete");
Route::delete("admin-users/destroy", [AdminUsers\AdminUsersController::class,"destroy"])->name("admin_users.delete");
Route::resource("admin-users", AdminUsers\AdminUsersController::class)->parameters(["admin-users" => "admin_users_id"])->names("admin_users")->except(["show"])->whereNumber("admin_users_id");
Route::post('admin-users/addcompanyaddress', [AdminUsers\AdminUsersController::class, 'addCompanyAddress']);
Route::get('admin-users/getaddressByUserId/{userId}', [AdminUsers\AdminUsersController::class, 'getCompanyAddress']);