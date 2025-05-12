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
namespace App\Requests\Admin\Salesreports;
use Illuminate\Foundation\Http\FormRequest;

class SalesreportsRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route("salesreports_id") ?? null;
		return [
            "my_id"=>[
				"string",
				"unique:salesreports,my_id,".$id.",id,deleted_at,NULL",
				"nullable",
				"max:255"
			],
			"distributorid"=>[
				"string",
				"nullable",
				"max:255"
			],
			"product_1"=>[
				"nullable"
			],
			"invoicenumber"=>[
				"string",
				"required",
				"max:255"
			],
			"invoicedate"=>[
				"string",
				"nullable",
				"max:255"
			],
			"reportmonth"=>[
				"string",
				"nullable",
				"max:255"
			],
			"week"=>[
				"string",
				"nullable",
				"max:255"
			],
			"customername"=>[
				"string",
				"nullable",
				"max:255"
			],
			"location"=>[
				"string",
				"nullable",
				"max:255"
			],
			"channel"=>[
				"string",
				"nullable",
				"max:255"
			],
			"qty"=>[
				"string",
				"nullable",
				"max:255"
			],
			"originalunitprice"=>[
				"string",
				"nullable",
				"max:255"
			],
			"grossamount"=>[
				"string",
				"nullable",
				"max:255"
			],
			"excelid"=>[
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
            "my_id"=>"id",
			"distributorid"=>"distributorId",
			"product_1"=>"product",
			"invoicenumber"=>"invoiceNumber",
			"invoicedate"=>"invoiceDate",
			"reportmonth"=>"reportMonth",
			"week"=>"week",
			"customername"=>"customerName",
			"location"=>"location",
			"channel"=>"channel",
			"qty"=>"qty",
			"originalunitprice"=>"originalUnitPrice",
			"grossamount"=>"grossAmount",
			"excelid"=>"excelId",
			"createdtime"=>"createdTime"
        ];
    }
    
}