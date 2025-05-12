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
namespace App\Requests\Admin\Stockreports;
use Illuminate\Foundation\Http\FormRequest;

class StockreportsRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route("stockreports_id") ?? null;
		return [
            "my_id"=>[
				"string",
				"unique:stockreports,my_id,".$id.",id,deleted_at,NULL",
				"nullable",
				"max:255"
			],
			"distributorid"=>[
				"string",
				"nullable",
				"max:255"
			],
			"productid"=>[
				"string",
				"nullable",
				"max:255"
			],
			"stockinhand"=>[
				"string",
				"required",
				"max:255"
			],
			"createdtime"=>[
				"string",
				"nullable",
				"max:255"
			],
			"excelid"=>[
				"string",
				"nullable",
				"max:255"
			]
        ];
    }
    public function attributes()
    {
        return [
            "my_id"=>"id",
			"distributorid"=>"distributorId",
			"productid"=>"productId",
			"stockinhand"=>"stockInHand",
			"createdtime"=>"createdTime",
			"excelid"=>"excelId"
        ];
    }
    
}