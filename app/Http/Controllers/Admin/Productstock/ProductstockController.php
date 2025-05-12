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
namespace App\Http\Controllers\Admin\Productstock;
use App\Http\Controllers\Controller;
use App\Models\Admin\Productstock\ProductstockExtended as Productstock;
use App\Requests\Admin\Productstock\ProductstockRequestExtended as ProductstockRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Countries\Countries;
use App\Models\Admin\Products\Products;
class ProductstockController extends Controller
{   
    public array $menu = ["item" =>"productstock", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['productstock_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $productstock_list_all = Productstock::startSearch(Request()->query("productstock_search"))->orderByDesc("id")->get();
        return view("admin.productstock.index")->with(compact('menu','productstock_list_all'))->fragmentIf(Request()->ajax_call==1, "productstock_fragment");
    }

    public function create()
    {
        if (Gate::none('productstock_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Productstock();
        
        return view("admin.productstock.form")->with(compact('menu','data'));
    }

    public function store(ProductstockRequest $request)
    {
        if (Gate::none('productstock_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Productstock::create($requestAll);
        

        return redirect(route("admin.productstock.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('productstock_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Productstock::findOrFail(request()->route()->productstock_id);;
        
        return view("admin.productstock.form")->with(compact('menu', 'data'));
    }

    public function update(ProductstockRequest $request)
    {
        if (Gate::none('productstock_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Productstock::findOrFail(request()->route()->productstock_id);
        $run->update($requestAll);
        return redirect(route("admin.productstock.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('productstock_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Productstock::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.productstock.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
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
	
    public function product_1_auto_complete()
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
}
