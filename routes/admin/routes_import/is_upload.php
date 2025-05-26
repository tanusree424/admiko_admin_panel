<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**PoUpload**/
/**PoUpload**/
Route::delete("is-upload/destroy", [IsUpload\IsUploadControllerExtended::class,"destroy"])->name("is_upload.delete");
Route::resource("is-upload", IsUpload\IsUploadControllerExtended::class)->parameters(["is-upload" => "is_upload_id"])->names("is_upload")->except(["show"])->whereNumber("is_upload_id");
// Route::post('is-upload/export', [IsUpload\IsUploadControllerExtended::class, 'export'])->name('admin.is_upload.export');
