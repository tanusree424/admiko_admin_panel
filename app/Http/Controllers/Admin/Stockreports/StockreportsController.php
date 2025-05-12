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
namespace App\Http\Controllers\Admin\Stockreports;
use App\Http\Controllers\Controller;
use App\Models\Admin\Stockreports\StockreportsExtended as Stockreports;
use App\Requests\Admin\Stockreports\StockreportsRequestExtended as StockreportsRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Orders\Orders;
use App\Exports\stockReportExport;
use Excel;


class StockreportsController extends Controller
{   
    public array $menu = ["item" =>"stockreports", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['stockreports_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $stockreports_list_all = Stockreports::startSearch(Request()->query("stockreports_search"))->orderByDesc("id")->get();
        return view("admin.stockreports.index")->with(compact('menu','stockreports_list_all'))->fragmentIf(Request()->ajax_call==1, "stockreports_fragment");
    }

    public function create()
    {
        if (Gate::none('stockreports_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Stockreports();
        
        return view("admin.stockreports.form")->with(compact('menu','data'));
    }

    public function store(StockreportsRequest $request)
    {
        if (Gate::none('stockreports_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Stockreports::create($requestAll);
        

        return redirect(route("admin.stockreports.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('stockreports_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Stockreports::findOrFail(request()->route()->stockreports_id);;
        
        return view("admin.stockreports.form")->with(compact('menu', 'data'));
    }

    public function update(StockreportsRequest $request)
    {
        if (Gate::none('stockreports_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Stockreports::findOrFail(request()->route()->stockreports_id);
        $run->update($requestAll);
        return redirect(route("admin.stockreports.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('stockreports_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Stockreports::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.stockreports.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }


public function showSummary($orderId)
{
        $purchaseorders_list_all = Stockreports::findAllStockReportByOrderId($orderId);
        return response()->json([
            'success' => true,
            'data' => $purchaseorders_list_all
        ], 200);
}

public function exportExcel($orderId)
{
    $stockreport = Stockreports::findAllStockReportByOrderId($orderId);
    $order = Orders::findById($orderId);

   // Sanitize the order number for safe file naming
   $sanitizedOrderNumber = str_replace(['/', '\\'], '-', $order->order_number);



    if (!$stockreport) {
        return redirect()->back()->with("toast_error", trans('admin/misc.error_no_data_found'));
    }
    
    // return Excel::download(new PurchaseOrderExport($purchaseorders), 'SalesReport-'.time().'.xlsx');
    return Excel::download(new stockReportExport($stockreport), 'Stock-Report-'. $sanitizedOrderNumber .'.xlsx');
}

public function deleteStockReport($orderId){
    $orderDelete = Orders::updateOrderStatus($orderId);
    $salesreport_list_all = Stockreports::updatePurchaseOrderStatus($orderId);
    return response()->json([
        'success' => true,
        'data' => $salesreport_list_all,
        'message' => $orderDelete ? 'Stock deleted successfully.' : 'Failed to delete Stock report.'
    ], 200);
}

public function confirmOrder($orderId)
{
   
	 $orderDelete = Orders::updateOrderconfirmStatus($orderId);
       
        return response()->json([
            'success' => true,
            
            'message' => $orderDelete ? ' Stock confirmed successfully.' : 'Failed to confirmed stock.'
        ], 200);
	
	
}

    
}
