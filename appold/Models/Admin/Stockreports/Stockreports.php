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
namespace App\Models\Admin\Stockreports;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Stockreports extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait;
    public $table = 'stockreports';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"my_id",
		"distributorid",
		"productid",
		"stockinhand",
		"createdtime",
		"excelid",
		"created_by",
		"updated_by",
		"deleted_by",
		"created_by_team",
    ];
    
    public function scopeStartSorting($query, $request)
    {
        if ($request->has('stockreports_sort_by') && $request->stockreports_sort_by) {
            if($request->stockreports_direction == "desc"){
                $query->orderByDesc($request->stockreports_sort_by);
            } else {
                $query->orderBy($request->stockreports_sort_by);
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
    public static function findAllStockReportByOrderId($orderId)
    {
        return DB::select('
            SELECT stockreports.id, stockreports.my_id, stockreports.distributorid, admin_users.name AS distributor_name,
stockreports.productid, stockreports.stockinhand, stockreports.createdtime, stockreports.excelid, 
stockreports.created_at, stockreports.updated_at, stockreports.deleted_at, stockreports.created_by, 
stockreports.updated_by, stockreports.deleted_by, stockreports.created_by_team , stockreports.orderid,
products.productname,
categories.catname,
brands.brandname AS brand_name,
products.partdescription AS part_description
FROM stockreports JOIN admin_users ON admin_users.id = stockreports.distributorid 
JOIN products ON stockreports.productid = products.partcode
JOIN brands ON products.brand = brands.id
JOIN categories ON categories.id = products.category
WHERE stockreports.orderid = ?
        ', [$orderId]);
    }

    public static function updatePurchaseOrderStatus($orderId)
{
    return self::where('orderid', $orderId)->update(['enabled' => 0]);
}

}