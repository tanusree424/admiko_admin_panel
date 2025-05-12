<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Purchaseorderspreview extends Model
{
    protected $table = 'purchaseorders_preview';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
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
		'orderid'
    ];
}
