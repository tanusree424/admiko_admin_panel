<?php

namespace App\Http\Controllers\Admin\SalesreportsView;
use App\Http\Controllers\Controller;
use App\Models\Admin\SalesreportsView\SalesreportsViewExtended as Salesreports;
use App\Requests\Admin\SalesreportsView\SalesreportsViewRequestExtended as SalesreportsRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Orders\Orders;
use App\Exports\salesReportExport;
use Excel;
use Auth;


class SalesreportsViewController extends Controller
{   
    public array $menu = ["item" =>"salesreports", "folder" =>"", "subfolder" =>""];



    public function index()
{
    $LoggedInUserRole = Auth::user()->rolesMany()->first()->title; 
    $userid = Auth::id();
    $menu = $this->menu;

    // Start building the query
    $query = Orders::select('orders.*', 'admin_users.name as admin_name', 'admin_users.id as admin_id')
                    ->join('admin_users', 'orders.created_by', '=', 'admin_users.id')
                    ->where('orders.prefix', "=", 'Sales')
                    ->where('orders.enabled', "=", '1')
                    ->orderBy('orders.created_at', 'desc');

    // Apply user filter if not Administrator
    if ($LoggedInUserRole != 'Administator') {
        $query->where('orders.created_by', $userid);
    }

    // Apply date filters if present
    if (!empty($_REQUEST['date_start']) && !empty($_REQUEST['date_end'])) {
        $query->whereDate('orders.created_at', '>=', $_REQUEST['date_start']);
        $query->whereDate('orders.created_at', '<=', $_REQUEST['date_end']);
    }

    $salesreports_list_all = $query->get();

    return view("admin.salesreports.index")
        ->with(compact('menu', 'salesreports_list_all'))
        ->fragmentIf(request()->ajax_call == 1, "salesreports_fragment");
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
    return Excel::download(new salesReportExport($salesreports), 'SalesReport-'. $sanitizedOrderNumber .'.xlsx');
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

    
}
