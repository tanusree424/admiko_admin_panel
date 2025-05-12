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
namespace App\Models\Admin\Purchaseorders;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchaseorders extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait;
    public $table = 'purchaseorders';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"poid",
		"distributorid",
		"productid",
		"ordertime",
		"orderprice",
		"orderqty",
		"updatedtime",
		"excelid",
		"status",
		"created_by",
		"updated_by",
		"deleted_by",
		"created_by_team",
    ];
    
    public function scopeStartSorting($query, $request)
    {
        if ($request->has('purchaseorders_sort_by') && $request->purchaseorders_sort_by) {
            if($request->purchaseorders_direction == "desc"){
                $query->orderByDesc($request->purchaseorders_sort_by);
            } else {
                $query->orderBy($request->purchaseorders_sort_by);
            }
        } else {
            $query->orderByDesc("id");
        }
    }
	public function scopeStartSearch($query, $search)
    {
        if ($search) {
            $query->where("id","like","%".$search."%");
        }
    }
}