<?php

namespace App\Requests\Admin\SubCategories;
use Illuminate\Foundation\Http\FormRequest;

class SubCategoriesRequest extends FormRequest
{
    public function rules()
    {
        return [
            "name"=>[
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
            "name"=>"name",
			"status"=>"status",
			"createdby"=>"createdBy",
			"createdtime"=>"createdTime"
        ];
    }
    
}