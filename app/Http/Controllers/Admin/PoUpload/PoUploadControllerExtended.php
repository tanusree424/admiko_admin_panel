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
use Illuminate\Http\Request;
use App\Imports\purchaseOrdersImport;
use App\Exports\purchaseOrder;
use App\Mail\POUploadedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\OrderType\OrderType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Excel;
use DB;

use Illuminate\Support\Facades\Log;


class PoUploadControllerExtended extends PoUploadController
{

public function store(Request $request)
{
    DB::beginTransaction();

    try {
        $userId = Auth::id();
        $file = $request->file('select_po_template');

        if (!$file) {
            return redirect()->back()->with("toast_error", "No file uploaded.");
        }

        $fileName = $file->getClientOriginalName();
        $prefix = explode('-', $fileName)[0];
        $orderType = OrderType::findByName($prefix);

        if ($orderType) {
            $orderType = "0" . $orderType;
        }

        if (!$orderType) {
            return redirect()->back()->with("toast_error", "Invalid order type.");
        }

        $currentMonthYear = Carbon::now()->format('my');
        $formattedUserId = strlen($userId) === 1 ? '0' . $userId : $userId;

        // ✅ Unique by using time to the second
        $orderNumber = sprintf(
            "%s/%s/%s/%s",
            $formattedUserId,
            $orderType,
            $currentMonthYear,
            Carbon::now()->format('His') // HHMMSS
        );

        // Insert order
        $orderId = DB::table('orders')->insertGetId([
            'order_number' => $orderNumber,
            'prefix'       => $prefix,
            'order_type'   => $orderType,
            'created_by'   => $userId,
            'file_name'    => $fileName,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ]);

        Excel::import(new PurchaseOrdersImport($orderId), $file);

        DB::commit();

        // Send email
        Mail::to('tanubasuchoudhury1997@gmail.com')->send(new POUploadedMail($orderNumber));

        return redirect()->route('admin.po_upload.preview')
            ->with("toast_success", "PO report uploaded and mail sent.");

    } catch (\Exception $ex) {
        DB::rollBack();
        \Log::error("Order Store Error: " . $ex->getMessage());
        return redirect()->back()->with("toast_error", $ex->getMessage());
    }
}


public function storffff(Request $request)
{
    try {
        $userId = Auth::id(); // Retrieves the ID of the currently authenticated user
        $file = $request->file('select_po_template');

        if (!$file) {
            return redirect()->back()->with("toast_error", "No file uploaded.");
        }

        $fileName = $file->getClientOriginalName();
        $prefix = explode('-', $fileName)[0];
        $orderType = OrderType::findByName($prefix);

        // Append 0 in `orderType`
        if ($orderType) {
            $orderType = "0" . $orderType;
        }
        \Log::error("orderType:::::::::::::::::> " . $orderType);

        if (!$orderType) {
            return redirect()->back()->with("toast_error", "Invalid order type.");
        }

        $currentMonthYear = Carbon::now()->format('my');
        $formattedUserId = strlen($userId) === 1 ? '0' . $userId : $userId;

        // Get the current date (only date part)
        $currentDate = Carbon::now()->toDateString();

        // Count the number of orders for the current date and `order_type`
        $orderCount = DB::table('orders')
            ->where('order_type', $orderType)
            ->whereDate('created_at', $currentDate) // Filter by only today's date
            ->count();

        \Log::info("Order Count for Today: " . $orderCount);

        // Determine the next sequence number
        $nextSequence = $orderCount + 1;

        // Generate the unique order number
        $orderNumber = sprintf("%s/%s/%s/%03d", $formattedUserId, $orderType, $currentMonthYear, $nextSequence);
		//dd($userId);

        // Insert the new order and retrieve its ID
        $orderId = DB::table('orders')->insertGetId([
            'order_number' => $orderNumber,
            'prefix'       => $prefix,
            'order_type'   => $orderType,
            'created_by'   => $userId,
            'file_name'    => $fileName,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ]);

        // Log the newly created order number
        \Log::info("Created Order Number: " . $orderNumber);

        // Import the purchase orders using Excel
        Excel::import(new PurchaseOrdersImport($orderId), $file);
         // After import, send mail
         //$userEmail = 'samirsing@gmail.com';

        // Send email with the hardcoded email address passed to the mailable constructor
        //Mail::to($userEmail)->send(new POUploadedMail($userEmail));

       // return back()->with('success', 'PO uploaded and email sent.');


      //  Mail::to($user->email)->send(new POUploadedMail('samirsing@gmail.com'));
// Mail::to($user->email)->send(new POUploadedMail($user->email)); // Pass necessary data to the email

       // return back()->with('success', 'PO imported and email sent.');
        return redirect()->route('admin.po_upload.preview');
    } catch (\Exception $ex) {
        \Log::error("Error Creating Order: " . $ex->getMessage());
        return redirect()->back()->with("toast_error", $ex->getMessage());
    }
}



    public function export(Request $request)
    {
        return Excel::download(new purchaseOrder, 'PO-detail-'.date('Ymdhis').'.xlsx');
    }



    public function preview(Request $request)
    {
        $data['results'] = DB::table('purchaseorders_preview as pp')
        ->select('pp.*', 'p.MOQ')
        ->join('products as p', 'p.partcode', '=', 'pp.productid')
        ->paginate(10);

        $data['menu'] = $this->menu;
        return view('admin.po-preview.index',$data);
    }

    // public function finalSubmit(Request $request)
    // {
    //     $purchaseOrders = DB::table('purchaseorders_preview')->get();

    //     if($purchaseOrders->count() > 0) {
    //         foreach($purchaseOrders as $row)
    //         {
    //             DB::table('purchaseorders')->insert([
    //                 'distributorid' => $row->distributorid,
    //                 'productid' => $row->productid,
    //                 'ordertime' => $row->ordertime,
    //                 'orderprice' => $row->orderprice,
    //                 'orderqty' => $row->orderqty,
    //                 'updatedtime' => Carbon::now(),
    //                 'excelid' => 'PO Import',
    //                 'status' => 'true',
    //                 'orderid' => $row->orderid,
    //                 'created_by' => $row->created_by,
    //             ]);
    //             //update order table set updatedtime = now() where id = $row->orderid
    //             DB::table('orders')->where('id', $row->orderid)->update([
    //                 'updated_at' => DB::raw('NOW()'),
    //                 'updated_by' => Auth::id(),
    //             ]);
    //         }
    //         DB::table('purchaseorders_preview')->truncate();
    //     }

    //     return redirect()->route('admin.purchaseorders.index')->with("toast_success", 'Purchase Orders Imported Successfully!');
    // }


public function finalSubmit(Request $request)
{
    DB::beginTransaction();

    try {
        $purchaseOrders = DB::table('purchaseorders_preview')->get();

        if ($purchaseOrders->count() > 0) {
            foreach ($purchaseOrders as $row) {

                // Insert into purchaseorders
                DB::table('purchaseorders')->insert([
                    'distributorid'   => $row->distributorid,
                    'productid'       => $row->productid,
                    'ordertime'       => $row->ordertime,
                    'orderprice'      => $row->orderprice,
                    'orderqty'        => $row->orderqty,
                    'updatedtime'     => Carbon::now(),
                    'excelid'         => 'PO Import',
                    'status'          => 'true',
                    'orderid'         => $row->orderid,
                    'created_by'      => $row->created_by,
                    'created_at'      => Carbon::now(),
                    'updated_at'      => Carbon::now(),
                ]);

                // Update orders table
                DB::table('orders')
                    ->where('id', $row->orderid)
                    ->update([
                        'updated_at' => Carbon::now(),
                        'updated_by' => Auth::id(),
                    ]);

                // Step 1: Get product by productid (not partcode)
                $product = DB::table('products')->where('partcode', $row->productid)->first();
                if (!$product) {
                    continue; // Skip if no matching product
                }

                // Step 2: Get inventory_stock from inventory_stocks
                $inventoryStock = DB::table('inventory_stocks')
                    ->where('productid', $row->productid)
                    ->value('inventory_stock'); // fetches single column

                $inventoryStock = (int) $inventoryStock;
                $orderQty = (int) $row->orderqty;
                $restStock = $inventoryStock - $orderQty;

                // Step 3: Insert into stock_transfer
                DB::table('stock_transfer')->insert([
                    'product_id'             => $product->partcode,
                    'product_name'           => $product->productname,
                    'brand_id'               => $product->brand,
                    'category_id'            => $product->category,
                    'subcategory_id'         => $product->subcategory,
                    'purchaseorder_quantity' => $orderQty,
                    'inventory_stock'        => $inventoryStock,
                    'rest_stock'             => $restStock,
                    'transfer_date'          => Carbon::now(),
                    'created_at'             => Carbon::now(),
                    'updated_at'             => Carbon::now(),
                ]);
            }

            // Clear preview table
            DB::table('purchaseorders_preview')->truncate();
        }

        DB::commit();

        return redirect()->route('admin.purchaseorders.index')
            ->with("toast_success", 'Purchase Orders Submitted. Inventory & Stock Transfer Updated!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("finalSubmit error: " . $e->getMessage());

        return back()->withErrors(['error' => 'Submission failed: ' . $e->getMessage()]);
    }
}

}
