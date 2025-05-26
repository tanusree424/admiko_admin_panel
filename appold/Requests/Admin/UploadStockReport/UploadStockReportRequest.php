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
namespace App\Requests\Admin\UploadStockReport;
use Illuminate\Foundation\Http\FormRequest;

class UploadStockReportRequest extends FormRequest
{
    public function rules()
    {
        return [
            "select_stock_report_template"=>[
				"file",
				"required_without:ak_select_stock_report_template_current",
				"max:5140",
				"file_extension:xls,xlsx",
				"mimes:xls,xlsx"
			]
        ];
    }
    public function attributes()
    {
        return [
            "select_stock_report_template"=>"Select Stock Report Template"
        ];
    }
    public function messages()
    {
        return [
            "select_stock_report_template.required_without"=>trans("validation.required"),
			"select_stock_report_template.file_extension"=>trans("admin/form.required_type")
        ];
    }


}