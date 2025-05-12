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
namespace App\Http\Controllers\Admin\PoUpload;
use App\Http\Controllers\Controller;
use App\Models\Admin\PoUpload\PoUploadExtended as PoUpload;
use App\Requests\Admin\PoUpload\PoUploadRequestExtended as PoUploadRequest;
use Illuminate\Support\Facades\Gate;
class PoUploadController extends Controller
{   
    public array $menu = ["item" =>"po_upload", "folder" =>"excelreport_uploads", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['po_upload_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        
        $row = PoUpload::first();
        if($row){
            return redirect(route("admin.po_upload.edit",$row->id));
        } else {
            return redirect(route("admin.po_upload.create"));
        }

        
    }

    public function create()
    {
        if (Gate::none('po_upload_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new PoUpload();
        
        return view("admin.po_upload.form")->with(compact('menu','data'));
    }

    public function store(PoUploadRequest $request)
    {
        if (Gate::none('po_upload_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = PoUpload::create($requestAll);
        

        return redirect(route("admin.po_upload.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('po_upload_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = PoUpload::findOrFail(request()->route()->po_upload_id);;
        
        return view("admin.po_upload.form")->with(compact('menu', 'data'));
    }

    public function update(PoUploadRequest $request)
    {
        if (Gate::none('po_upload_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = PoUpload::findOrFail(request()->route()->po_upload_id);
        $run->update($requestAll);
        return back()->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('po_upload_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        PoUpload::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.po_upload.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
