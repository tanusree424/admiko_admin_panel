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
namespace App\Requests\Admin\Products;
use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route("products_id") ?? null;
		return [
            "productid"=>[
				"string",
				"unique:products,productid,".$id.",id,deleted_at,NULL",
				"nullable",
				"max:255"
			],
			"category"=>[
				"nullable"
			],
			"brand"=>[
				"nullable"
			],
			"productname"=>[
				"string",
				"required",
				"max:255"
			],
			"partcode"=>[
				"string",
				"required",
				"max:255"
			],
			"partdescription"=>[
				"string",
				"nullable",
				"max:255"
			],
			"excelid"=>[
				"string",
				"nullable",
				"max:255"
			],
			"status"=>[
				"string",
				"nullable",
				"max:255"
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
            "productid"=>"productId",
			"category"=>"Category",
			"brand"=>"Brand",
			"productname"=>"productName",
			"partcode"=>"partCode",
			"partdescription"=>"partDescription",
			"excelid"=>"excelId",
			"status"=>"status",
			"createdby"=>"createdBy",
			"createdtime"=>"createdTime"
        ];
    }
    
}