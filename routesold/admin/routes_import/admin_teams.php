<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**AdminTeams**/
/**AdminTeams**/
Route::delete("admin-teams/destroy", [AdminTeams\AdminTeamsController::class,"destroy"])->name("admin_teams.delete");
Route::get("admin-teams/show/{admin_teams_id}", [AdminTeams\AdminTeamsController::class,"show"])->name("admin_teams.show")->whereNumber("admin_teams_id");
Route::resource("admin-teams", AdminTeams\AdminTeamsController::class)->parameters(["admin-teams" => "admin_teams_id"])->names("admin_teams")->except(["show"])->whereNumber("admin_teams_id");