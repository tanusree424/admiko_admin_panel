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
namespace App\Requests\Admin\UploadSalesReport;
use Illuminate\Foundation\Http\FormRequest;

class UploadSalesReportRequest extends FormRequest
{
    public function rules()
    {
        return [
            "sales_report_template_upload"=>[
				"file",
				"required_without:ak_sales_report_template_upload_current",
				"max:5140",
				"file_extension:xls,xlsx",
				"mimes:xls,xlsx"
			]
        ];
    }
    public function attributes()
    {
        return [
            "sales_report_template_upload"=>"Sales Report Template Upload"
        ];
    }
    public function messages()
    {
        return [
            "sales_report_template_upload.required_without"=>trans("validation.required"),
			"sales_report_template_upload.file_extension"=>trans("admin/form.required_type")
        ];
    }


}