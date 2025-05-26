<?php
/**
 * @author Admiko
 * @copyright Copyright (c) Admiko
 * @link https://admiko.com
 * @Help We are committed to delivering the best code quality and user experience. If you have suggestions or find any issues, please don't hesitate to contact us. Thank you.
 *
 * Add CUSTOM PROTECTED admin authentication routes here. Our system will not overwrite it.
 */
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;


Route::post('export-purchase-order', [PoUpload\PoUploadControllerExtended::class, 'export'])->name('po_upload.export');
Route::post('export-inventory-stock', [IsUpload\ISUploadControllerExtended::class, 'export'])->name('is_upload.export');
Route::get('po-preview', [PoUpload\PoUploadControllerExtended::class, 'preview'])->name('po_upload.preview');
Route::get('is-preview', [IsUpload\IsUploadControllerExtended::class,'preview'])->name('is_upload.preview');
Route::post('is-submit', [IsUpload\IsUploadControllerExtended::class,'finalSubmit'])->name('is_upload.submit');
Route::post('po-submit', [PoUpload\PoUploadControllerExtended::class, 'finalSubmit'])->name('po_upload.submit');
Route::get('stock-preview', [StockReportUpload\StockReportUploadControllerExtended::class, 'preview'])->name('stock_upload.preview');
Route::post('stock-submit', [StockReportUpload\StockReportUploadControllerExtended::class, 'finalSubmit'])->name('stock_upload.submit');
Route::post('export-sales-report', [UploadSalesReport\UploadSalesReportControllerExtended::class, 'export'])->name('upload_sales_report.export');
Route::get('export-stock-report', [UploadStockReport\UploadStockReportControllerExtended::class, 'export'])->name('upload_stock_report.export');
Route::post('export-stock-template', [StockReportUpload\StockReportUploadControllerExtended::class, 'export'])->name('export_stock_template.export');


