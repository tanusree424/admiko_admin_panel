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
namespace App\Models\Admin\AdminAuditableLogs;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminService\Auth\AuthUser;

class AdminAuditableLogs extends Model
{
    
    public $table = 'admin_auditable_logs';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"action",
		"user_id",
		"model",
		"row_id",
		"properties_old",
		"properties_new",
		"url",
		"ip",
    ];
    
    public function userIdListAll()
    {
        return AuthUser::all()->sortBy("name");
    }
	public function userIdToValue()
    {
        return $this->belongsTo(AuthUser::class, 'user_id');
    }
	public function scopeStartSorting($query, $request)
    {
        if ($request->has('admin_auditable_logs_sort_by') && $request->admin_auditable_logs_sort_by) {
            if($request->admin_auditable_logs_direction == "desc"){
                $query->orderByDesc($request->admin_auditable_logs_sort_by);
            } else {
                $query->orderBy($request->admin_auditable_logs_sort_by);
            }
        } else {
            $query->orderByDesc("id")->orderByDesc("created_at");
        }
    }
	public function scopeStartSearch($query, $search)
    {
        if ($search) {
            $query->where("action","like","%".$search."%")
			->orWhereHas("userIdToValue", function($q) use($search) { $q->where("name","like","%".$search."%"); })
			->orWhere("model","like","%".$search."%")
			->orWhere("row_id","like","%".$search."%")
			->orWhere("properties_old","like","%".$search."%")
			->orWhere("properties_new","like","%".$search."%")
			->orWhere("url","like","%".$search."%")
			->orWhere("ip","like","%".$search."%");
        }
    }
}