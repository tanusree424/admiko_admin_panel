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
namespace App\Http\Controllers\Admin\UploadSalesReport;
use App\Http\Controllers\Controller;
use App\Models\Admin\UploadSalesReport\UploadSalesReportExtended as UploadSalesReport;
use App\Requests\Admin\UploadSalesReport\UploadSalesReportRequestExtended as UploadSalesReportRequest;
use Illuminate\Support\Facades\Gate;
class UploadSalesReportController extends Controller
{   
    public array $menu = ["item" =>"upload_sales_report", "folder" =>"excelreport_uploads", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['upload_sales_report_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        
        $row = UploadSalesReport::first();
        if($row){
            return redirect(route("admin.upload_sales_report.edit",$row->id));
        } else {
            return redirect(route("admin.upload_sales_report.create"));
        }

        
    }

    public function create()
    {
        if (Gate::none('upload_sales_report_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new UploadSalesReport();
        
        return view("admin.upload_sales_report.form")->with(compact('menu','data'));
    }

    public function store(UploadSalesReportRequest $request)
    {
        if (Gate::none('upload_sales_report_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = UploadSalesReport::create($requestAll);
        

        return redirect(route("admin.upload_sales_report.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('upload_sales_report_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = UploadSalesReport::findOrFail(request()->route()->upload_sales_report_id);;
        
        return view("admin.upload_sales_report.form")->with(compact('menu', 'data'));
    }

    public function update(UploadSalesReportRequest $request)
    {
        if (Gate::none('upload_sales_report_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = UploadSalesReport::findOrFail(request()->route()->upload_sales_report_id);
        $run->update($requestAll);
        return back()->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('upload_sales_report_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        UploadSalesReport::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.upload_sales_report.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
