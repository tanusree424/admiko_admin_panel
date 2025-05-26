<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Productstocklogs**/
/**Productstocklogs**/
Route::delete("productstocklogs/destroy", [Productstocklogs\ProductstocklogsController::class,"destroy"])->name("productstocklogs.delete");
Route::resource("productstocklogs", Productstocklogs\ProductstocklogsController::class)->parameters(["productstocklogs" => "productstocklogs_id"])->names("productstocklogs")->except(["show"])->whereNumber("productstocklogs_id");