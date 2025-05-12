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
namespace App\Http\Controllers\Admin\Salesreports;
use App\Http\Controllers\Controller;
use App\Models\Admin\Salesreports\Salesreports;
use App\Requests\Admin\Salesreports\SalesreportsRequest;
use Illuminate\Support\Facades\Gate;
class SalesreportsController extends Controller
{   
    public array $menu = ["item" =>"salesreports", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['salesreports_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $salesreports_list_all = Salesreports::startSearch(Request()->query("salesreports_search"))->orderByDesc("id")->get();
        return view("admin.salesreports.index")->with(compact('menu','salesreports_list_all'))->fragmentIf(Request()->ajax_call==1, "salesreports_fragment");
    }

    public function create()
    {
        if (Gate::none('salesreports_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Salesreports();
        
        return view("admin.salesreports.form")->with(compact('menu','data'));
    }

    public function store(SalesreportsRequest $request)
    {
        if (Gate::none('salesreports_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Salesreports::create($requestAll);
        

        return redirect(route("admin.salesreports.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('salesreports_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Salesreports::findOrFail(request()->route()->salesreports_id);;
        
        return view("admin.salesreports.form")->with(compact('menu', 'data'));
    }

    public function update(SalesreportsRequest $request)
    {
        if (Gate::none('salesreports_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Salesreports::findOrFail(request()->route()->salesreports_id);
        $run->update($requestAll);
        return redirect(route("admin.salesreports.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('salesreports_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Salesreports::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.salesreports.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
