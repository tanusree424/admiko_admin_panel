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
namespace App\Models\Admin\AdminTeams;
use Illuminate\Database\Eloquent\Model;


class AdminTeams extends Model
{
    
    public $table = 'admin_teams';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"name",
    ];
    
    public function scopeStartSorting($query, $request)
    {
        if ($request->has('admin_teams_sort_by') && $request->admin_teams_sort_by) {
            if($request->admin_teams_direction == "desc"){
                $query->orderByDesc($request->admin_teams_sort_by);
            } else {
                $query->orderBy($request->admin_teams_sort_by);
            }
        } else {
            $query->orderBy("name");
        }
    }
	public function scopeStartSearch($query, $search)
    {
        if ($search) {
            $query->where("name","like","%".$search."%");
        }
    }
}