<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class StockUploadPreview extends Model
{
    protected $table = 'stock_upload_preview';

    protected $fillable = [
		"part_code",
		"stock_in_hand",
        "orderid",
        "created_at"
    ];
}
