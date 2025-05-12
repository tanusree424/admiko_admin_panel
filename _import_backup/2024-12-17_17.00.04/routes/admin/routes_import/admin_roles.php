<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**AdminRoles**/
/**AdminRoles**/
Route::delete("admin-roles/destroy", [AdminRoles\AdminRolesController::class,"destroy"])->name("admin_roles.delete");
Route::resource("admin-roles", AdminRoles\AdminRolesController::class)->parameters(["admin-roles" => "admin_roles_id"])->names("admin_roles")->except(["show"])->whereNumber("admin_roles_id");