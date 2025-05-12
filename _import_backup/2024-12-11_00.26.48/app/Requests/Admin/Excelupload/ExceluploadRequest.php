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
namespace App\Requests\Admin\Excelupload;
use Illuminate\Foundation\Http\FormRequest;

class ExceluploadRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route("excelupload_id") ?? null;
		return [
            "excelid"=>[
				"string",
				"unique:excelupload,excelid,".$id.",id,deleted_at,NULL",
				"nullable",
				"max:255"
			],
			"exceltype"=>[
				"string",
				"required",
				"max:255"
			],
			"excelpath"=>[
				"string",
				"required",
				"max:255"
			],
			"uploadedby"=>[
				"string",
				"nullable",
				"max:255"
			],
			"uploadedtime"=>[
				"string",
				"nullable",
				"max:255"
			]
        ];
    }
    public function attributes()
    {
        return [
            "excelid"=>"excelId",
			"exceltype"=>"excelType",
			"excelpath"=>"excelPath",
			"uploadedby"=>"uploadedBy",
			"uploadedtime"=>"uploadedTime"
        ];
    }
    
}