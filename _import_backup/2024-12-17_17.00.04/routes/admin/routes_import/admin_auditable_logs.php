<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**AdminAuditableLogs**/
/**AdminAuditableLogs**/
Route::delete("admin-auditable-logs/destroy", [AdminAuditableLogs\AdminAuditableLogsController::class,"destroy"])->name("admin_auditable_logs.delete");
Route::get("admin-auditable-logs/show/{admin_auditable_logs_id}", [AdminAuditableLogs\AdminAuditableLogsController::class,"show"])->name("admin_auditable_logs.show")->whereNumber("admin_auditable_logs_id");
Route::resource("admin-auditable-logs", AdminAuditableLogs\AdminAuditableLogsController::class)->parameters(["admin-auditable-logs" => "admin_auditable_logs_id"])->names("admin_auditable_logs")->except(["show"])->whereNumber("admin_auditable_logs_id");