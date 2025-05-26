<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**PoDistributorsView**/
Route::get("po-distributors-view", [PoDistributorsView\PoDistributorsViewController::class,"index"])->name("po_distributors_view");
/**PurchaseOrders**/
Route::delete("po-distributors-view/purchase-orders/destroy", [PoDistributorsView\PurchaseOrdersControllerExtended::class,"destroy"])->name("po_distributors_view.purchase_orders.delete");
Route::resource("po-distributors-view/purchase-orders", PoDistributorsView\PurchaseOrdersControllerExtended::class)->parameters(["purchase-orders" => "purchase_orders_id"])->names("po_distributors_view.purchase_orders")->except(["show"])->whereNumber("purchase_orders_id");