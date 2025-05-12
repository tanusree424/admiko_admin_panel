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
namespace App\Requests\Admin\ProductCountryMapping;
use Illuminate\Foundation\Http\FormRequest;

class ProductCountryMappingRequest extends FormRequest
{
    public function rules()
    {
        return [
            "products"=>[
				"required"
			],
			"country"=>[
				"required"
			],
			"price"=>[
				"string",
				"required",
				"max:255"
			],
			"status"=>[
				"required",
				"max:30"
			]
        ];
    }
    public function attributes()
    {
        return [
            "products"=>"Products",
			"country"=>"Country",
			"price"=>"Price",
			"status"=>"Status"
        ];
    }
    
}