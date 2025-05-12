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
namespace App\Http\Controllers\Admin\Purchaseorders;
use App\Http\Controllers\Controller;
use App\Models\Admin\Purchaseorders\Purchaseorders;
use App\Requests\Admin\Purchaseorders\PurchaseordersRequest;
use Illuminate\Support\Facades\Gate;
class PurchaseordersController extends Controller
{   
    public array $menu = ["item" =>"purchaseorders", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['purchaseorders_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $purchaseorders_list_all = Purchaseorders::startSearch(Request()->query("purchaseorders_search"))->orderByDesc("id")->get();
        return view("admin.purchaseorders.index")->with(compact('menu','purchaseorders_list_all'))->fragmentIf(Request()->ajax_call==1, "purchaseorders_fragment");
    }

    public function create()
    {
        if (Gate::none('purchaseorders_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Purchaseorders();
        
        return view("admin.purchaseorders.form")->with(compact('menu','data'));
    }

    public function store(PurchaseordersRequest $request)
    {
        if (Gate::none('purchaseorders_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Purchaseorders::create($requestAll);
        

        return redirect(route("admin.purchaseorders.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('purchaseorders_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Purchaseorders::findOrFail(request()->route()->purchaseorders_id);;
        
        return view("admin.purchaseorders.form")->with(compact('menu', 'data'));
    }

    public function update(PurchaseordersRequest $request)
    {
        if (Gate::none('purchaseorders_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Purchaseorders::findOrFail(request()->route()->purchaseorders_id);
        $run->update($requestAll);
        return redirect(route("admin.purchaseorders.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('purchaseorders_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Purchaseorders::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.purchaseorders.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
