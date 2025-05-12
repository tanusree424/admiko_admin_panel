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
namespace App\Requests\Admin\Brands;
use Illuminate\Foundation\Http\FormRequest;

class BrandsRequest extends FormRequest
{
    public function rules()
    {
        return [
            "brandname"=>[
				"string",
				"required",
				"max:255"
			],
			"status"=>[
				"nullable",
				"max:30"
			],
			"createdby"=>[
				"string",
				"nullable",
				"max:255"
			],
			"createdtime"=>[
				"string",
				"nullable",
				"max:255"
			]
        ];
    }
    public function attributes()
    {
        return [
            "brandname"=>"brandName",
			"status"=>"status",
			"createdby"=>"createdBy",
			"createdtime"=>"createdTime"
        ];
    }
    
}