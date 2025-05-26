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
namespace App\Models\Admin\Products;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Brands\Brands;
use App\Models\Admin\Categories\Categories;
use App\Models\Admin\SubCategories\SubCategories;

class Products extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait;
    public $table = 'products';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		
		"category",
			 'subcategory',
		"brand",
		"productname",
		"partcode",
		"eancode",
		"hsncode",		
		"MOQ",
		"partdescription",
		"excelid",
		"status",
		"createdby",
		"createdtime",
		"created_by",
		"updated_by",
		"deleted_by",
		"created_by_team",
    ];
    
	const STATUS_CONS = ["Active"=>"Active","Inactive"=>"Inactive"];
    public function categoryListAll()
    {
        return Categories::all()->sortBy("catname");
    }

public function subcategoryListAll()
    {
        return SubCategories::all()->sortBy("name");
    }

	
	public function categoryToValue()
    {
        return $this->belongsTo(Categories::class, 'category');
    }

//category
	public function scategoriesToValue()
    {
     // $product->subCategory->name;
		
		return $this->belongsTo(SubCategories::class, 'subcategory');

		
    }
	public function brandListAll()
    {
        return Brands::all()->sortBy("brandname");
    }
	public function brandToValue()
    {
        return $this->belongsTo(Brands::class, 'brand');
    }
	public function scopeStartSorting($query, $request)
    {
        if ($request->has('products_sort_by') && $request->products_sort_by) {
            if($request->products_direction == "desc"){
                $query->orderByDesc($request->products_sort_by);
            } else {
                $query->orderBy($request->products_sort_by);
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