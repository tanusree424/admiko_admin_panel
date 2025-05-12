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
namespace App\Requests\Admin\Userloginsession;
use Illuminate\Foundation\Http\FormRequest;

class UserloginsessionRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route("userloginsession_id") ?? null;
		return [
            "sessionid"=>[
				"string",
				"unique:userloginsession,sessionid,".$id.",id,deleted_at,NULL",
				"nullable",
				"max:255"
			],
			"userid"=>[
				"string",
				"nullable",
				"max:255"
			],
			"logintime"=>[
				"string",
				"nullable",
				"max:255"
			],
			"logouttime"=>[
				"string",
				"nullable",
				"max:255"
			],
			"ipaddress"=>[
				"string",
				"nullable",
				"max:255"
			]
        ];
    }
    public function attributes()
    {
        return [
            "sessionid"=>"sessionId",
			"userid"=>"userId",
			"logintime"=>"loginTime",
			"logouttime"=>"logoutTime",
			"ipaddress"=>"ipAddress"
        ];
    }
    
}