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
namespace App\Requests\Admin\Productstocklogs;
use Illuminate\Foundation\Http\FormRequest;

class ProductstocklogsRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route("productstocklogs_id") ?? null;
		return [
            "logid"=>[
				"string",
				"unique:productstocklogs,logid,".$id.",id,deleted_at,NULL",
				"nullable",
				"max:255"
			],
			"stockid"=>[
				"string",
				"nullable",
				"max:255"
			],
			"quantity"=>[
				"string",
				"required",
				"max:255"
			],
			"price"=>[
				"string",
				"nullable",
				"max:255"
			],
			"comment"=>[
				"string",
				"nullable",
				"max:255"
			],
			"updatedby"=>[
				"string",
				"nullable",
				"max:255"
			],
			"updatedtime"=>[
				"string",
				"nullable",
				"max:255"
			]
        ];
    }
    public function attributes()
    {
        return [
            "logid"=>"logId",
			"stockid"=>"stockId",
			"quantity"=>"quantity",
			"price"=>"price",
			"comment"=>"comment",
			"updatedby"=>"updatedBy",
			"updatedtime"=>"updatedTime"
        ];
    }
    
}