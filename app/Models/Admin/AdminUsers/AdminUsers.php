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
namespace App\Models\Admin\AdminUsers;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminHelperTrait;
use App\Models\Admin\AdminRoles\AdminRoles;
use App\Models\Admin\AdminTeams\AdminTeams;
use App\Models\Admin\Orders\Orders;

class AdminUsers extends Model
{
    use AdminHelperTrait;
    public $table = 'admin_users';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"name",
		"email",
		"image",
		"password",
		"language",
		"show_language",
		"theme",
		"show_theme",
		"active",
		"team_id",
    ];
    
    public function setImageAttribute()
    {
        if (request()->filled('image')) {
            $this->attributes['image'] = request()->image;
        }
    }
	public function setPasswordAttribute($value)
    {
        if($value != ''){
            $this->attributes['password'] = bcrypt($value);
        }
    }
	public function rolesListAll()
    {
        return AdminRoles::all()->sortBy("title");
    }
	public function rolesMany()
    {
        return $this->belongsToMany(AdminRoles::class, 'admin_user_role', 'admin_users_id', 'admin_roles_id');
    }
	public function multiTenancyListAll()
    {
        return AdminUsers::all()->sortBy("name");
    }
	public function multiTenancyMany()
    {
        return $this->belongsToMany(AdminUsers::class, 'admin_user_tenancy', 'admin_users_id', 'admin_user_tenancy_id');
    }
	public function teamIdListAll()
    {
        return AdminTeams::all()->sortBy("name");
    }
	public function teamIdToValue()
    {
        return $this->belongsTo(AdminTeams::class, 'team_id');
    }
	public function scopeStartSorting($query, $request)
    {
        if ($request->has('admin_users_sort_by') && $request->admin_users_sort_by) {
            if($request->admin_users_direction == "desc"){
                $query->orderByDesc($request->admin_users_sort_by);
            } else {
                $query->orderBy($request->admin_users_sort_by);
            }
        } else {
            $query->orderBy("id");
        }
    }
	public function scopeStartSearch($query, $search)
    {
        if ($search) {
            $query->where("name","like","%".$search."%")
			->orWhere("email","like","%".$search."%")
			->orWhereHas("rolesMany", function($q) use($search) { $q->where("title","like","%".$search."%"); });
        }
    }

    public function orders()
      {
          return $this->hasMany(Orders::class, 'created_by');
      }


}