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
namespace App\Requests\Admin\AdminPermissions;
use Illuminate\Foundation\Http\FormRequest;

class AdminPermissionsRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route("admin_permissions_id") ?? null;
		return [
            "title"=>[
				"string",
				"required",
				"max:255"
			],
			"permission_slug"=>[
				"string",
				"unique:admin_permissions,permission_slug,".$id.",id,deleted_at,NULL",
				"required",
				"max:255"
			]
        ];
    }
    public function attributes()
    {
        return [
            "title"=>"Title",
			"permission_slug"=>"Permission slug"
        ];
    }
    
}