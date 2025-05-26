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
namespace App\Requests\Admin\Users;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route("users_id") ?? null;
		return [

			"name"=>[
				"string",
				"nullable",
				"max:255"
			],
			"email"=>[
				"string",
				"required",
				"max:255"
			],
			"password"=>[
				"string",
				"nullable",
				"max:255"
			],

        ];
    }
    public function attributes()
    {
        return [
            "userid"=>"userId",
			"fullname"=>"fullName",
			"emailaddress"=>"emailAddress",
			"password"=>"password",
			"countryid"=>"countryId",
			"role"=>"role",
			"status"=>"status",
			"createdtime"=>"createdTime"
        ];
    }

}
