<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Excelupload**/
/**Excelupload**/
Route::delete("excelupload/destroy", [Excelupload\ExceluploadController::class,"destroy"])->name("excelupload.delete");
Route::resource("excelupload", Excelupload\ExceluploadController::class)->parameters(["excelupload" => "excelupload_id"])->names("excelupload")->except(["show"])->whereNumber("excelupload_id");