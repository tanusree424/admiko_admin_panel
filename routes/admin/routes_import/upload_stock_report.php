<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**UploadStockReport**/
/**UploadStockReport**/
Route::delete("upload-stock-report/destroy", [UploadStockReport\UploadStockReportControllerExtended::class,"destroy"])->name("upload_stock_report.delete");
Route::resource("upload-stock-report", UploadStockReport\UploadStockReportControllerExtended::class)->parameters(["upload-stock-report" => "upload_stock_report_id"])->names("upload_stock_report")->except(["show"])->whereNumber("upload_stock_report_id");