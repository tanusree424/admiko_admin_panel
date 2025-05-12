<?php
/**
* @author Admiko
* @copyright Copyright (c) Admiko
* @link https://admiko.com
* @Help We are committed to delivering the best code quality and user experience. If you have suggestions or find any issues, please don't hesitate to contact us. Thank you.
* This file is managed by Admiko and is not recommended to be modified.
* Any custom code should be added elsewhere to avoid losing changes during updates.
* However, in case your code is overwritten, you can always restore it from a backup folder.
*/
namespace App\Requests\Admin\StockReportUpload;
use Illuminate\Foundation\Http\FormRequest;

class StockReportUploadRequest extends FormRequest
{
    public function rules()
    {
        return [
            "stock_report_file"=>[
				"file",
				"required_without:ak_stock_report_file_current",
				"max:10280",
				"file_extension:xls,xslx",
				"mimes:xls,xslx"
			]
        ];
    }
    public function attributes()
    {
        return [
            "stock_report_file"=>"Stock Report"
        ];
    }
    public function messages()
    {
        return [
            "stock_report_file.required_without"=>trans("validation.required"),
			"stock_report_file.file_extension"=>trans("admin/form.required_type")
        ];
    }


}