<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Stockreports**/
/**Stockreports**/
Route::delete("stocktransfer/destroy", [stocktransfer\stockTransferController::class,"destroy"])->name("stocktransfer.delete");
Route::resource("stocktransfer", stocktransfer\stockTransferController::class)->parameters(["stocktransfer" => "stocktransfer_id"])->names("stocktransfer")->except(["show"])->whereNumber("stocktransfer_id");
Route::post('/admin/stock-upload-submit', [
    stocktransfer\stockTransferUploadController::class,
    'transferStock'
])->name('stock_upload.submit');
