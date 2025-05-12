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
namespace App\Http\Controllers\Admin\Excelupload;
use App\Http\Controllers\Controller;
use App\Models\Admin\Excelupload\Excelupload;
use App\Requests\Admin\Excelupload\ExceluploadRequest;
use Illuminate\Support\Facades\Gate;
class ExceluploadController extends Controller
{   
    public array $menu = ["item" =>"excelupload", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['excelupload_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $excelupload_list_all = Excelupload::startSearch(Request()->query("excelupload_search"))->orderByDesc("id")->get();
        return view("admin.excelupload.index")->with(compact('menu','excelupload_list_all'))->fragmentIf(Request()->ajax_call==1, "excelupload_fragment");
    }

    public function create()
    {
        if (Gate::none('excelupload_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Excelupload();
        
        return view("admin.excelupload.form")->with(compact('menu','data'));
    }

    public function store(ExceluploadRequest $request)
    {
        if (Gate::none('excelupload_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Excelupload::create($requestAll);
        

        return redirect(route("admin.excelupload.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('excelupload_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Excelupload::findOrFail(request()->route()->excelupload_id);;
        
        return view("admin.excelupload.form")->with(compact('menu', 'data'));
    }

    public function update(ExceluploadRequest $request)
    {
        if (Gate::none('excelupload_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Excelupload::findOrFail(request()->route()->excelupload_id);
        $run->update($requestAll);
        return redirect(route("admin.excelupload.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('excelupload_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Excelupload::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.excelupload.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
