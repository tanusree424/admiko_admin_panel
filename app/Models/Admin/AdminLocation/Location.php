<?php
// app/Models/Location.php

namespace App\Models\Admin\AdminLocation;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Countries\Countries;
class Location extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait;
    protected $fillable = ['location_name', 'region', 'country_id'];
    public $table = "locations";

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
    public function scopeStartSorting($query, $request)
    {
        if ($request->has('location_sort_by') && $request->location_sort_by) {
            if($request->location_direction == "desc"){
                $query->orderByDesc($request->location_sort_by);
            } else {
                $query->orderBy($request->location_sort_by);
            }
        } else {
            $query->orderByDesc("id");
        }
    }
	public function scopeStartSearch($query, $search)
{
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('location_name', 'like', "%{$search}%")
              ->orWhere('region', 'like', "%{$search}%")
              ->orWhereHas('country', function ($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              });
        });
    }

    return $query->orderByDesc('id');
}


}
