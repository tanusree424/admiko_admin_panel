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
namespace App\Models\Admin\InventoryStock;
use App\Models\Admin\Products\Products;

class inventorystocksExtended extends inventorystocks
{
     protected $fillable = [
        'distributorid',
        'productid',
        'ordertime',
        'orderprice',
        'orderqty',
        'updatedtime',
        'excelid',
        'status',
        'inventory_stock'
        // Add any other actual database columns here
    ];

    public function distributorInfo()
    {
        return $this->belongsTo('App\Models\Admin\AdminUsers\AdminUsers','distributorid');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'productid', 'partcode');
    }
}
