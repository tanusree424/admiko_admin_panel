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

namespace App\Models\Admin\SubCategories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Categories\Categories;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;

class SubCategories extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait;

    public $table = 'sub_categories';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'status',
        'category_id', 
        'created_at',
        'updated_at',
    ];

    // Status constants
    const STATUS_CONS = [
        'Active' => 'Active',
        'Inactive' => 'Inactive',
    ];

    /**
     * Relationship to Categories
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category');
    }

    /**
     * Get sorted category list
     */
    public function categoryListAll()
    {
        return Categories::all()->sortBy('catname');
    }

    /**
     * Scope: apply sorting based on request input
     */
    public function scopeStartSorting($query, $request)
    {
        if ($request->has('sub_categories_sort_by') && $request->sub_categories_sort_by) {
            if ($request->sub_categories_direction == "desc") {
                $query->orderByDesc($request->sub_categories_sort_by);
            } else {
                $query->orderBy($request->sub_categories_sort_by);
            }
        } else {
            $query->orderByDesc('id');
        }
    }

    /**
     * Scope: apply search filter
     */
    public function scopeStartSearch($query, $search)
    {
        if ($search) {
            $query->where('id', 'like', '%' . $search . '%');
        }
    }
}
