<?php

namespace App\Http\Controllers\Admin\StockTransfer;

use Illuminate\Http\Request;
use App\Models\Admin\Stocktransfer\Stocktransfer;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB;
// use Illuminate\Http\Request;

class stockTransferUploadController extends Controller
{
    /**
     * Store AWB Number and Transfer Date
     */


public function transferStock(Request $request)
{
    $request->validate([
        'product_id' => 'required|string',
        'awb_number' => 'required|string|max:20',
        'transfer_date' => 'required|date',
    ]);

    // Get stock row
    $stock = DB::table('stock_transfer')
        ->where('product_id', $request->product_id)
        ->first();

    if (!$stock) {
        return back()->withErrors(['error' => 'Product not found']);
    }

    $purchaseQty = (int) $stock->purchaseorder_quantity;
    $currentInventory = (int) $stock->inventory_stock;

    if ($currentInventory < $purchaseQty) {
        return back()->withErrors(['error' => 'Insufficient inventory stock to transfer this quantity.']);
    }

    $newInventoryStock = $currentInventory - $purchaseQty;
    $newRestStock = $purchaseQty;

    // Update the values in DB
    $updated = DB::update("
        UPDATE stock_transfer
        SET inventory_stock = ?,
            rest_stock = ?,
            AWB_number = ?,
            transfer_date = ?
        WHERE product_id = ?
    ", [
        $newInventoryStock,
        $newRestStock,
        $request->awb_number,
        $request->transfer_date,
        $request->product_id
    ]);

    if ($updated) {
        return redirect()->route('admin.stocktransfer.index')
            ->with('toast_success', 'Stock transferred successfully!');
    } else {
        return back()->withErrors(['error' => 'Update failed. Please try again.']);
    }
}




}
