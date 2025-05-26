<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**AdminPermissions**/
/**AdminPermissions**/
Route::delete("admin-permissions/destroy", [AdminPermissions\AdminPermissionsController::class,"destroy"])->name("admin_permissions.delete");
Route::resource("admin-permissions", AdminPermissions\AdminPermissionsController::class)->parameters(["admin-permissions" => "admin_permissions_id"])->names("admin_permissions")->except(["show"])->whereNumber("admin_permissions_id");