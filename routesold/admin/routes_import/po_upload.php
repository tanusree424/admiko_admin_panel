<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**PoUpload**/
/**PoUpload**/
Route::delete("po-upload/destroy", [PoUpload\PoUploadControllerExtended::class,"destroy"])->name("po_upload.delete");
Route::resource("po-upload", PoUpload\PoUploadControllerExtended::class)->parameters(["po-upload" => "po_upload_id"])->names("po_upload")->except(["show"])->whereNumber("po_upload_id");