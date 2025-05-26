<?php

namespace App\Http\Controllers\Admin\InventoryStock;

use App\Http\Controllers\Controller;
use App\Models\Admin\InventoryStock\inventorystocksExtended as InventoryStock;
use App\Requests\Admin\InventoryStock\InventorystockRequestExtended as InventoryStockRequest;
use Illuminate\Support\Facades\Gate;
use App\Exports\InventoryStockExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Admin\Orders\Orders;
use App\Models\Admin\CompanyAddresses\CompanyAddresses;
use App\Models\Admin\VendorAddress\VendorAddress;

class InventoryStockController extends Controller
{
    public array $menu = ["item" => "inventorystocks", "folder" => "", "subfolder" => ""];

    public function index(Request $request)
    {
        if (Gate::none('inventorystock_access')) {
            abort(403);
        }

        $menu = $this->menu;

		$inventorystock_list_all = InventoryStock::with('products')
            ->startSearch($request->query("inventorystock_search"))
            ->orderByDesc("id")
            ->get();
    return  dd($inventorystock_list_all);
// return view("admin.inventorystocks.index", compact('menu', 'inventorystock_list_all'))
//     ->fragmentIf($request->ajax_call == 1, "inventorystock_fragment");

    }

    public function create()
    {
        if (Gate::denies('inventorystock_create')) {
            abort(403);
        }

        $menu = $this->menu;
        $data = new InventoryStock();

        return view("admin.inventorystocks.form", compact('menu', 'data'));
    }

    public function store(InventoryStockRequest $request)
    {
        if (Gate::denies('inventorystock_create')) {
            abort(403);
        }

        InventoryStock::create($request->validated());

        return redirect()->route("admin.inventorystock.index")
            ->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit($inventorystock_id)
    {
        if (Gate::denies('inventorystock_edit')) {
            abort(403);
        }

        $menu = $this->menu;
        $data = InventoryStock::findOrFail($inventorystock_id);

        return view("admin.inventorystock.form", compact('menu', 'data'));
    }

    public function update(InventoryStockRequest $request, $inventorystock_id)
    {
        if (Gate::denies('inventorystock_edit')) {
            abort(403);
        }

        $inventory = InventoryStock::findOrFail($inventorystock_id);
        $inventory->update($request->validated());

        return redirect()->route("admin.inventorystock.index")
            ->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy(Request $request)
    {
        if (Gate::denies('inventorystock_delete')) {
            if ($request->ajax_call == 1) {
                return response()->json([
                    'success' => false,
                    'message' => trans('admin/misc.forbidden_access_error')
                ]);
            }
            abort(403);
        }

        InventoryStock::destroy($request->delete_id);

        if ($request->ajax_call == 1) {
            return response()->json([
                'success' => true,
                'message' => trans('admin/misc.success_confirmation_deleted')
            ]);
        }

        return redirect()->route("admin.inventorystock.index")
            ->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
    }

    public function showSummary($orderId)
    {
        $data = InventoryStock::findAllinventorystocksById($orderId);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function exportExcel($orderId)
    {
        $inventorystock = InventoryStock::findAllinventorystocksById($orderId);
        $order = Orders::findById($orderId);
        $sanitizedOrderNumber = str_replace(['/', '\\'], '-', $order->order_number);

        if (!$inventorystock) {
            return redirect()->back()->with("toast_error", trans('admin/misc.error_no_data_found'));
        }

        return Excel::download(new InventoryStockExport($inventorystock), 'inventorystock-' . $sanitizedOrderNumber . '.xlsx');
    }

    public function exportPdf($orderId, $userId)
    {
        $inventorystock = InventoryStock::findAllinventorystocksById($orderId);
        $orderDetails = Orders::findById($orderId);
        $address = CompanyAddresses::getAddressByAdminUserLid($userId);
        $vendorAddress = VendorAddress::findAll();

        if (!$inventorystock || $inventorystock->isEmpty()) {
            return redirect()->back()->with("toast_error", trans('admin/misc.error_no_data_found'));
        }

        $pdf = Pdf::loadView('admin.inventorystock.pdf', compact('inventorystock', 'orderDetails', 'address', 'vendorAddress'));
        return $pdf->download('inventorystock.pdf');
    }

    public function deleteIS($orderId)
    {
        $orderDelete = Orders::updateOrderStatus($orderId);
        $data = InventoryStock::updateinventorystockstatus($orderId);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $orderDelete ? 'Inventory stock deleted successfully.' : 'Failed to delete purchase order.'
        ]);
    }

    public function confirmOrder($orderId)
    {
        $confirmed = Orders::updateOrderconfirmStatus($orderId);

        return response()->json([
            'success' => true,
            'message' => $confirmed ? 'Inventory stock confirmed successfully.' : 'Failed to confirm inventory stock.'
        ]);
    }
}
