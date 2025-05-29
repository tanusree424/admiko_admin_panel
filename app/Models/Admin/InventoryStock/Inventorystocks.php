<?php

namespace App\Models\Admin\inventorystock;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Products\Products;
use Illuminate\Support\Facades\DB;

class inventorystocks extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait;
    public $table = 'inventory_stocks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


	const STATUS_CONS = ["Active"=>"Active","Inactive"=>"Inactive"];
    public function scopeStartSorting($query, $request)
    {
        if ($request->has('inventory_stock_sort_by') && $request->inventory_stock_sort_by) {
            if($request->inventorystocks_direction == "desc"){
                $query->orderByDesc($request->inventory_stock_sort_by);
            } else {
                $query->orderBy($request->inventory_stock_sort_by);
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


public static function findAllinventorystocksById($orderId)
{
    return DB::table(DB::raw('
        (
            SELECT
                inventory_stocks.orderid,
                inventory_stocks.id AS id,

                inventory_stocks.distributorid,
                admin_users.name AS distributor_name,
                inventory_stocks.productid,
                inventory_stocks.ordertime,
                inventory_stocks.orderprice,
                inventory_stocks.inventory_stock,
                inventory_stocks.updatedtime,
                inventory_stocks.excelid,
                inventory_stocks.status,
                inventory_stocks.created_at,
                inventory_stocks.updated_at,
                inventory_stocks.deleted_at,
                inventory_stocks.created_by,
                inventory_stocks.updated_by,
                inventory_stocks.deleted_by,

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
                ROW_NUMBER() OVER (PARTITION BY inventory_stocks.id ORDER BY inventory_stocks.ordertime) AS rn
            FROM inventory_stocks
            JOIN products ON CONVERT(inventory_stocks.productid USING utf8mb4) COLLATE utf8mb4_unicode_ci = products.partcode
            JOIN brands ON products.brand = brands.id
            JOIN product_country_mapping ON products.id = product_country_mapping.products
            JOIN countries ON product_country_mapping.country = countries.id
            JOIN admin_users  ON admin_users.id = inventory_stocks.distributorid
            JOIN categories ON categories.id = products.category
            WHERE inventory_stocks.orderid = ' . intval($orderId) . ' AND inventory_stocks.status = "true"
        ) AS ranked
    '))
    ->where('rn', 1)
    ->get();
}




public static function findAllinventorystocks()
{
    return self::select(
            'inventorystocks.*',
            'products.id as product_id',
            'products.productname',
            'products.partcode',
            'products.moq'
        )
        ->join('products', 'inventorystocks.productid', '=', 'products.partcode')
        ->where('inventorystocks.status', 'true')
        ->get();
}

public static function updateinventorystockstatus($orderId)
{
    return self::where('orderid', $orderId)->update(['status' => 'false']);
}

}
