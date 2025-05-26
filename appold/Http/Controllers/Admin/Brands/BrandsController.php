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
namespace App\Http\Controllers\Admin\Brands;
use App\Http\Controllers\Controller;
use App\Models\Admin\Brands\BrandsExtended as Brands;
use App\Requests\Admin\Brands\BrandsRequestExtended as BrandsRequest;
use Illuminate\Support\Facades\Gate;
class BrandsController extends Controller
{   
    public array $menu = ["item" =>"brands", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['brands_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $brands_list_all = Brands::startSearch(Request()->query("brands_search"))->orderByDesc("id")->get();
        return view("admin.brands.index")->with(compact('menu','brands_list_all'))->fragmentIf(Request()->ajax_call==1, "brands_fragment");
    }

    public function create()
    {
        if (Gate::none('brands_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Brands();
        
        return view("admin.brands.form")->with(compact('menu','data'));
    }

    public function store(BrandsRequest $request)
    {
        if (Gate::none('brands_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Brands::create($requestAll);
        

        return redirect(route("admin.brands.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('brands_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Brands::findOrFail(request()->route()->brands_id);;
        
        return view("admin.brands.form")->with(compact('menu', 'data'));
    }

    public function update(BrandsRequest $request)
    {
        if (Gate::none('brands_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Brands::findOrFail(request()->route()->brands_id);
        $run->update($requestAll);
        return redirect(route("admin.brands.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('brands_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Brands::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.brands.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
