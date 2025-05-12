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
namespace App\Models\Admin\Salesreports;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Products\Products;
use Excel;
use Auth;
use DB;

class Salesreports extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait;
    public $table = 'salesreports';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"my_id",
		"distributorid",
		"productid",
		"invoicenumber",
		"invoicedate",
		"reportmonth",
		"week",
		"customername",
		"location",
		"channel",
		"qty",
		"originalunitprice",
		"grossamount",
		"excelid",
		"createdtime",
		"created_by",
        'orderid',
		"updated_by",
		"deleted_by",
		"created_by_team",
    ];
    
    public function product1ListAll()
    {
        return Products::all()->sortBy("id");
    }
	public function product1ToValue()
    {
        return $this->belongsTo(Products::class, 'product_1');
    }
	public function scopeStartSorting($query, $request)
    {
        if ($request->has('salesreports_sort_by') && $request->salesreports_sort_by) {
            if($request->salesreports_direction == "desc"){
                $query->orderByDesc($request->salesreports_sort_by);
            } else {
                $query->orderBy($request->salesreports_sort_by);
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


    public static function findAllSalesReportByOrderId($orderId)
    {
        return DB::select('
SELECT salesreports.id, salesreports.my_id, salesreports.distributorid, admin_users.name AS distributor_name, 
salesreports.productid, salesreports.invoicenumber,
salesreports.invoicedate, salesreports.reportmonth, salesreports.week, salesreports.customername, salesreports.location,
salesreports.channel, salesreports.qty , salesreports.originalunitprice,  salesreports.grossamount, salesreports.excelid, 
salesreports.createdtime, salesreports.created_at, salesreports.updated_at , salesreports.deleted_at, salesreports.created_by ,
products.productname,
categories.catname,
brands.brandname AS brand_name,
products.partdescription AS part_description
FROM salesreports 
JOIN orders ON orders.id = salesreports.orderid
JOIN admin_users ON admin_users.id = salesreports.distributorid
JOIN products ON salesreports.productid = products.partcode
JOIN brands ON products.brand = brands.id
JOIN categories ON categories.id = products.category
WHERE salesreports.enabled = 1 AND orders.enabled =1 AND salesreports.orderid = ?
        ', [$orderId]);
    }

public static function updatePurchaseOrderStatus($orderId)
{
    return self::where('orderid', $orderId)->update(['enabled' => 0]);
}

	
}