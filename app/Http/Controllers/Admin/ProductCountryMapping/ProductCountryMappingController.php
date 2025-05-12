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
namespace App\Http\Controllers\Admin\ProductCountryMapping;
use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCountryMapping\ProductCountryMappingExtended as ProductCountryMapping;
use App\Requests\Admin\ProductCountryMapping\ProductCountryMappingRequestExtended as ProductCountryMappingRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Countries\Countries;
use App\Models\Admin\Products\Products;
class ProductCountryMappingController extends Controller
{   
    public array $menu = ["item" =>"product_country_mapping", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['product_country_mapping_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $product_country_mapping_list_all = ProductCountryMapping::startSearch(Request()->query("product_country_mapping_search"))->orderByDesc("id")->get();
        return view("admin.product_country_mapping.index")->with(compact('menu','product_country_mapping_list_all'))->fragmentIf(Request()->ajax_call==1, "product_country_mapping_fragment");
    }

    public function create()
    {
        if (Gate::none('product_country_mapping_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new ProductCountryMapping();
        
        return view("admin.product_country_mapping.form")->with(compact('menu','data'));
    }

    public function store(ProductCountryMappingRequest $request)
    {
        if (Gate::none('product_country_mapping_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = ProductCountryMapping::create($requestAll);
        

        return redirect(route("admin.product_country_mapping.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('product_country_mapping_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = ProductCountryMapping::findOrFail(request()->route()->product_country_mapping_id);;
        
        return view("admin.product_country_mapping.form")->with(compact('menu', 'data'));
    }

    public function update(ProductCountryMappingRequest $request)
    {
        if (Gate::none('product_country_mapping_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = ProductCountryMapping::findOrFail(request()->route()->product_country_mapping_id);
        $run->update($requestAll);
        return redirect(route("admin.product_country_mapping.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('product_country_mapping_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        ProductCountryMapping::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.product_country_mapping.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
    public function products_auto_complete()
    {
        if(Request()->has('q')){
            $data = Products::select("id","productname")
            ->orWhere("productname","LIKE","%".Request()->q."%")
            ->limit(50)->get()->sortBy("id");
        } else {
            $data = Products::select("id","productname")->limit(50)->get()->sortBy("id");
        }
        $return = $data->map(function ($item) {
            return ['id' => $item->id,'text' => $item->productname." "];
        });
        return response()->json($return);
    }
	
    public function country_auto_complete()
    {
        if(Request()->has('q')){
            $data = Countries::select("id","countryname")
            ->orWhere("countryname","LIKE","%".Request()->q."%")
            ->limit(50)->get()->sortBy("id");
        } else {
            $data = Countries::select("id","countryname")->limit(50)->get()->sortBy("id");
        }
        $return = $data->map(function ($item) {
            return ['id' => $item->id,'text' => $item->countryname." "];
        });
        return response()->json($return);
    }
}
