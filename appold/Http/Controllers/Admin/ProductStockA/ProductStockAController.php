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
namespace App\Http\Controllers\Admin\ProductStockA;
use App\Http\Controllers\Controller;
use App\Models\Admin\ProductStockA\ProductStockAExtended as ProductStockA;
use App\Requests\Admin\ProductStockA\ProductStockARequestExtended as ProductStockARequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Products\Products;
class ProductStockAController extends Controller
{   
    public array $menu = ["item" =>"product_stock_a", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['product_stock_a_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $product_stock_a_list_all = ProductStockA::startSearch(Request()->query("product_stock_a_search"))->orderByDesc("id")->get();
        return view("admin.product_stock_a.index")->with(compact('menu','product_stock_a_list_all'))->fragmentIf(Request()->ajax_call==1, "product_stock_a_fragment");
    }

    public function create()
    {
        if (Gate::none('product_stock_a_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new ProductStockA();
        
        return view("admin.product_stock_a.form")->with(compact('menu','data'));
    }

    public function store(ProductStockARequest $request)
    {
        if (Gate::none('product_stock_a_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = ProductStockA::create($requestAll);
        

        return redirect(route("admin.product_stock_a.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('product_stock_a_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = ProductStockA::findOrFail(request()->route()->product_stock_a_id);;
        
        return view("admin.product_stock_a.form")->with(compact('menu', 'data'));
    }

    public function update(ProductStockARequest $request)
    {
        if (Gate::none('product_stock_a_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = ProductStockA::findOrFail(request()->route()->product_stock_a_id);
        $run->update($requestAll);
        return back()->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('product_stock_a_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        ProductStockA::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.product_stock_a.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
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
