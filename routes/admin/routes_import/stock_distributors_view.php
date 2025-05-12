<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**PoDistributorsView**/
Route::get("stock-distributors-view", [StockDistributorsView\StockDistributorsViewController::class,"index"])->name("stock_distributors_view");
/**PurchaseOrders**/
//Route::delete("stock-distributors-view/purchase-orders/destroy", [StockDistributorsView\PurchaseOrdersControllerExtended::class,"destroy"])->name("sales_distributors_view.purchase_orders.delete");
//Route::resource("stock-distributors-view/purchase-orders", StockDistributorsView\PurchaseOrdersControllerExtended::class)->parameters(["purchase-orders" => "purchase_orders_id"])->names("sales_distributors_view.purchase_orders")->except(["show"])->whereNumber("purchase_orders_id");