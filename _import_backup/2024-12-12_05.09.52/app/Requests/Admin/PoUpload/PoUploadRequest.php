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
namespace App\Requests\Admin\PoUpload;
use Illuminate\Foundation\Http\FormRequest;

class PoUploadRequest extends FormRequest
{
    public function rules()
    {
        return [
            "select_po_template"=>[
				"file",
				"required_without:ak_select_po_template_current",
				"max:5140",
				"file_extension:xls,xlsx",
				"mimes:xls,xlsx"
			]
        ];
    }
    public function attributes()
    {
        return [
            "select_po_template"=>"Select PO Template"
        ];
    }
    public function messages()
    {
        return [
            "select_po_template.required_without"=>trans("validation.required"),
			"select_po_template.file_extension"=>trans("admin/form.required_type")
        ];
    }


}