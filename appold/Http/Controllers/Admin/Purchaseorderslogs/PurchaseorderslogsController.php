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
namespace App\Http\Controllers\Admin\Purchaseorderslogs;
use App\Http\Controllers\Controller;
use App\Models\Admin\Purchaseorderslogs\PurchaseorderslogsExtended as Purchaseorderslogs;
use App\Requests\Admin\Purchaseorderslogs\PurchaseorderslogsRequestExtended as PurchaseorderslogsRequest;
use Illuminate\Support\Facades\Gate;
class PurchaseorderslogsController extends Controller
{   
    public array $menu = ["item" =>"purchaseorderslogs", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['purchaseorderslogs_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $purchaseorderslogs_list_all = Purchaseorderslogs::startSearch(Request()->query("purchaseorderslogs_search"))->orderByDesc("id")->get();
        return view("admin.purchaseorderslogs.index")->with(compact('menu','purchaseorderslogs_list_all'))->fragmentIf(Request()->ajax_call==1, "purchaseorderslogs_fragment");
    }

    public function create()
    {
        if (Gate::none('purchaseorderslogs_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Purchaseorderslogs();
        
        return view("admin.purchaseorderslogs.form")->with(compact('menu','data'));
    }

    public function store(PurchaseorderslogsRequest $request)
    {
        if (Gate::none('purchaseorderslogs_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Purchaseorderslogs::create($requestAll);
        

        return redirect(route("admin.purchaseorderslogs.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('purchaseorderslogs_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Purchaseorderslogs::findOrFail(request()->route()->purchaseorderslogs_id);;
        
        return view("admin.purchaseorderslogs.form")->with(compact('menu', 'data'));
    }

    public function update(PurchaseorderslogsRequest $request)
    {
        if (Gate::none('purchaseorderslogs_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Purchaseorderslogs::findOrFail(request()->route()->purchaseorderslogs_id);
        $run->update($requestAll);
        return redirect(route("admin.purchaseorderslogs.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('purchaseorderslogs_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Purchaseorderslogs::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.purchaseorderslogs.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
