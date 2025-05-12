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
namespace App\Requests\Admin\AdminUsers;
use Illuminate\Foundation\Http\FormRequest;

class AdminUsersRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route("admin_users_id") ?? null;
		return [
            "name"=>[
				"string",
				"required",
				"max:100"
			],
			"email"=>[
				"email:filter",
				"unique:admin_users,email,".$id.",id,deleted_at,NULL",
				"required",
				"max:100"
			],
			"image"=>[
				"base64_validator:jpg,png,jpeg,webp",
				"required_without:ak_image_current"
			],
			"language"=>[
				"required",
				"max:15"
			],
			"theme"=>[
				"required",
				"max:20"
			],
			"roles"=>[
				"array",
				"required",
				"sometimes"
			],
			"multi_tenancy"=>[
				"array",
				"nullable"
			],
			"team_id"=>[
				"nullable"
			]
        ];
    }
    public function attributes()
    {
        return [
            "name"=>"Name",
			"email"=>"Email",
			"image"=>"Image",
			"language"=>"Language",
			"theme"=>"Theme",
			"roles"=>"Roles",
			"multi_tenancy"=>"Multi-Tenancy",
			"team_id"=>"Team"
        ];
    }
    public function messages()
    {
        return [
            "image.base64_validator"=>trans("validation.required")
        ];
    }


}