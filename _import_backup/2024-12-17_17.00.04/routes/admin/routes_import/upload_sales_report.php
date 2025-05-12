<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**UploadSalesReport**/
/**UploadSalesReport**/
Route::delete("upload-sales-report/destroy", [UploadSalesReport\UploadSalesReportControllerExtended::class,"destroy"])->name("upload_sales_report.delete");
Route::resource("upload-sales-report", UploadSalesReport\UploadSalesReportControllerExtended::class)->parameters(["upload-sales-report" => "upload_sales_report_id"])->names("upload_sales_report")->except(["show"])->whereNumber("upload_sales_report_id");