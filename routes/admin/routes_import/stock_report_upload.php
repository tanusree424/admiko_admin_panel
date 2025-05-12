<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**StockReportUpload**/
/**StockReportUpload**/
Route::delete("stock-report-upload/destroy", [StockReportUpload\StockReportUploadControllerExtended::class,"destroy"])->name("stock_report_upload.delete");
Route::resource("stock-report-upload", StockReportUpload\StockReportUploadControllerExtended::class)->parameters(["stock-report-upload" => "stock_report_upload_id"])->names("stock_report_upload")->except(["show"])->whereNumber("stock_report_upload_id");