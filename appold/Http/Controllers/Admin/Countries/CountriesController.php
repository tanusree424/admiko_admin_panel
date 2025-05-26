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
namespace App\Http\Controllers\Admin\Countries;
use App\Http\Controllers\Controller;
use App\Models\Admin\Countries\CountriesExtended as Countries;
use App\Requests\Admin\Countries\CountriesRequestExtended as CountriesRequest;
use Illuminate\Support\Facades\Gate;
class CountriesController extends Controller
{   
    public array $menu = ["item" =>"countries", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['countries_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $countries_list_all = Countries::startSearch(Request()->query("countries_search"))->orderByDesc("id")->get();
        return view("admin.countries.index")->with(compact('menu','countries_list_all'))->fragmentIf(Request()->ajax_call==1, "countries_fragment");
    }

    public function create()
    {
        if (Gate::none('countries_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Countries();
        
        return view("admin.countries.form")->with(compact('menu','data'));
    }

    public function store(CountriesRequest $request)
    {
        if (Gate::none('countries_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Countries::create($requestAll);
        

        return redirect(route("admin.countries.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('countries_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Countries::findOrFail(request()->route()->countries_id);;
        
        return view("admin.countries.form")->with(compact('menu', 'data'));
    }

    public function update(CountriesRequest $request)
    {
        if (Gate::none('countries_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Countries::findOrFail(request()->route()->countries_id);
        $run->update($requestAll);
        return redirect(route("admin.countries.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('countries_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Countries::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.countries.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
