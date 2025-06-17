<?php

namespace App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class StockReportController extends Controller
{
    public array $menu = ["item" =>"report_access", "folder" =>"excelreport_uploads", "subfolder" =>""];
    public function index()
{
     if (Gate::none(['report_access'])) {
            abort(403);
        }
		$menu = $this->menu;
    // Total inventory stock from `inventory_stocks`
    $inventory = DB::table('inventory_stocks')
        ->select('productid', DB::raw('SUM(CAST(inventory_stock AS UNSIGNED)) as total_inventory'))
        ->groupBy('productid');

    // Total transferred quantity from `stock_transfer`
    $transferred = DB::table('stock_transfer')
        ->select('product_id', DB::raw('SUM(CAST(purchaseorder_quantity AS UNSIGNED)) as total_transferred'))
        ->groupBy('product_id');

    // Total ordered quantity from `inventory_stocks` (if `orderid` represents purchase orders)
    $orders = DB::table('inventory_stocks')
        ->select('productid', DB::raw('COUNT(orderid) as total_orders')) // count of orders per product
        ->groupBy('productid');

    // Final merged report
    $report = DB::table('products')
        ->leftJoinSub($inventory, 'i', 'products.partcode', '=', 'i.productid')
        ->leftJoinSub($transferred, 't', 'products.partcode', '=', 't.product_id')
        ->leftJoinSub($orders, 'o', 'products.partcode', '=', 'o.productid')
        ->select(
            'products.partcode',
            'products.productname as name',
            DB::raw('COALESCE(i.total_inventory, 0) as total_inventory'),
            DB::raw('COALESCE(t.total_transferred, 0) as total_transferred'),
            DB::raw('COALESCE(o.total_orders, 0) as total_orders')
        )
        ->orderByDesc('total_orders')
        ->get();
// dd($report);
    return view('admin.stockReport.stockReport', compact('report','menu'));
}

}
