<?php

namespace App\Http\Controllers\Admin\Salesreports;

use App\Http\Controllers\Controller;
use App\Models\Admin\Salesreports\SalesreportsExtended as Salesreports;
use App\Requests\Admin\Salesreports\SalesreportsRequestExtended as SalesreportsRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Orders\Orders;
use App\Mail\POUploadedMail;
use Illuminate\Support\Facades\Mail;
use App\Exports\salesReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class SalesreportsController extends Controller
{   
    public array $menu = ["item" =>"salesreports", "folder" =>"", "subfolder" =>""];



   public function index(Request $request)
{
    $LoggedInUserRole = Auth::user()->rolesMany()->first()->title; 
    $userid = Auth::id();
    $menu = $this->menu;

    $query = Orders::select('orders.*', 'admin_users.name as admin_name', 'admin_users.id as admin_id')
                    ->join('admin_users', 'orders.created_by', '=', 'admin_users.id')
                    ->where('orders.prefix', '=', 'Sales')
                    ->where('orders.enabled', '=', '1')
                    ->orderBy('orders.created_at', 'desc');

    if ($LoggedInUserRole != 'Administator') {
        $query->where('orders.created_by', $userid);
    }

    if (!empty($request->input('date_start')) && !empty($request->input('date_end'))) {
        $query->whereDate('orders.created_at', '>=', $request->input('date_start'));
        $query->whereDate('orders.created_at', '<=', $request->input('date_end'));
    }

    $salesreports_list_all = $query->get();

    $response = view('admin.salesreports.index')
                ->with(compact('menu', 'salesreports_list_all', 'LoggedInUserRole'))
                ->fragmentIf($request->input('ajax_call') == 1, 'salesreports_fragment');

    if ($request->isMethod('post')) {
        $orderNumber = $request->input('order_number');

      //  Mail::to('samirsing@gmail.com')->send(new POUploadedMail($orderNumber));

        $response = redirect()
                    ->route('admin.po_upload.preview')
                    ->with('toast_success', 'Sales report uploaded and mail sent.');
    }

    return $response;
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

    public function showSummary($orderId)
    {
        $purchaseorders_list_all = Salesreports::findAllSalesReportByOrderId($orderId);
        return response()->json([
            'success' => true,
            'data' => $purchaseorders_list_all
        ], 200);
    }

public function exportExcel($orderId)
{
    $salesreport = Salesreports::findAllSalesReportByOrderId($orderId);

    $order = Orders::findById($orderId);

    // Sanitize the order number for safe file naming
    $sanitizedOrderNumber = str_replace(['/', '\\'], '-', $order->order_number);

    if (!$salesreport) {
        return redirect()->back()->with("toast_error", trans('admin/misc.error_no_data_found'));
    }
    // return Excel::download(new PurchaseOrderExport($purchaseorders), 'SalesReport-'.time().'.xlsx');
    return Excel::download(new salesReportExport($salesreport), 'SalesReport-'. $sanitizedOrderNumber .'.xlsx');
}

public function deleteSalesReport($orderId){
    $orderDelete = Orders::updateOrderStatus($orderId);
    $salesreport_list_all = Salesreports::updatePurchaseOrderStatus($orderId);
    return response()->json([
        'success' => true,
        'data' => $salesreport_list_all,
        'message' => $orderDelete ? 'Sales report deleted successfully.' : 'Failed to delete sales report.'
    ], 200);
}
public function confirmOrder($orderId)
{
   
	 $orderDelete = Orders::updateOrderconfirmStatus($orderId);
       
        return response()->json([
            'success' => true,
            
            'message' => $orderDelete ? 'Sales report confirmed successfully.' : 'Failed to confirmed sales report.'
        ], 200);
	
	
}
    
}
