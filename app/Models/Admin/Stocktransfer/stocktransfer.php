<?php

namespace App\Models\Admin\Stocktransfer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Categories\Categories;
use App\Models\Admin\SubCategories\SubCategories;
use App\Models\Admin\Brands\Brands;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;

class Stocktransfer extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait;

    public $table = 'stock_transfer'; // Matches your DB table

    protected $fillable = [
        'product_id',
        'brand_id',
        'category_id',
        'subcategory_id',
        'purchaseorder_quantity',
        'inventory_stock',
        'rest_stock',
        'AWB_number',
        'transfer_date'
    ];

    // Optional: If you want to automatically cast ID-based fields
    protected $casts = [
        'brand_id' => 'integer',
        'category_id' => 'integer',
        'subcategory_id' => 'integer',
    ];

    // Optional: define relationships if they exist
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategories::class, 'subcategory_id'); // Assuming same model
    }
    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id'); // Assuming same model
    }
}
