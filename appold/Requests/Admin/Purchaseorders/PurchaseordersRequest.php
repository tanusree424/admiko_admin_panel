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
namespace App\Requests\Admin\Purchaseorders;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseordersRequest extends FormRequest
{
    public function rules()
    {
        return [
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
			"ordertime"=>[
				"string",
				"nullable",
				"max:255"
			],
			"orderprice"=>[
				"string",
				"nullable",
				"max:255"
			],
			"orderqty"=>[
				"string",
				"required",
				"max:255"
			],
			"updatedtime"=>[
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
				"nullable",
				"max:30"
			]
        ];
    }
    public function attributes()
    {
        return [
            "distributorid"=>"distributorId",
			"productid"=>"productId",
			"ordertime"=>"orderTime",
			"orderprice"=>"orderPrice",
			"orderqty"=>"orderQty",
			"updatedtime"=>"updatedTime",
			"excelid"=>"excelId",
			"status"=>"status"
        ];
    }
    
}