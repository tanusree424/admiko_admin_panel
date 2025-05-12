<?php

namespace App\Models\Admin\Purchaseorders;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Products\Products;
use Illuminate\Support\Facades\DB;

class Purchaseorders extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait;
    public $table = 'purchaseorders';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    
	const STATUS_CONS = ["Active"=>"Active","Inactive"=>"Inactive"];
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

    public function product()
    {
        return $this->belongsTo(Products::class, 'productid', 'partcode');
    }


public static function findAllPurchaseOrdersById($orderId)
{
    return DB::table(DB::raw('
        (
            SELECT 
                purchaseorders.orderid,
                purchaseorders.id AS id,
                purchaseorders.poid,
                purchaseorders.distributorid,
                admin_users.name AS distributor_name,
                purchaseorders.productid,
                purchaseorders.ordertime,
                purchaseorders.orderprice,
                purchaseorders.orderqty,
                purchaseorders.updatedtime,
                purchaseorders.excelid,
                purchaseorders.status,
                purchaseorders.created_at,
                purchaseorders.updated_at,
                purchaseorders.deleted_at,
                purchaseorders.created_by,
                purchaseorders.updated_by,
                purchaseorders.deleted_by,
                purchaseorders.created_by_team,
                products.id AS product_id,
                products.productname,
                products.partcode,
                products.moq,
                categories.catname,
                brands.brandname AS brand_name,
                products.partdescription AS part_description,
                countries.countryname AS country_name,
                product_country_mapping.price AS price,
                countries.currency AS currency,
                ROW_NUMBER() OVER (PARTITION BY purchaseorders.id ORDER BY purchaseorders.ordertime) AS rn
            FROM purchaseorders
            JOIN products ON purchaseorders.productid = products.partcode
            JOIN brands ON products.brand = brands.id
            JOIN product_country_mapping ON products.id = product_country_mapping.products
            JOIN countries ON product_country_mapping.country = countries.id
            JOIN admin_users  ON admin_users.id = purchaseorders.distributorid
            join categories on categories.id = products.category
            WHERE  purchaseorders.orderid = ' . intval($orderId) . ' and purchaseorders.status = "true"
        ) AS ranked
    '))
    ->where('rn', 1)
    ->get();
}



public static function findAllPurchaseOrders()
{
    return self::select(
            'purchaseorders.*',
            'products.id as product_id',
            'products.productname',
            'products.partcode',
            'products.moq'
        )
        ->join('products', 'purchaseorders.productid', '=', 'products.partcode')
        ->where('purchaseorders.status', 'true')
        ->get();
}

public static function updatePurchaseOrderStatus($orderId)
{
    return self::where('orderid', $orderId)->update(['status' => 'false']);
}

}