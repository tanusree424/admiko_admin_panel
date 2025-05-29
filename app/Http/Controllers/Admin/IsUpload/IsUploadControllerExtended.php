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
namespace App\Http\Controllers\Admin\IsUpload;
use Illuminate\Http\Request;
use App\Imports\InventorystocksImport;
use App\Exports\InventoryStock;
use App\Mail\POUploadedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\OrderType\OrderType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Excel;
use DB;

class ISUploadControllerExtended extends ISUploadController
{

public function store(Request $request)
{
   DB::beginTransaction(); // Start transaction

    try {
        $userId = Auth::id();
        $file = $request->file('select_is_template');

        if (!$file) {
            return redirect()->back()->with("toast_error", "No file uploaded.");
        }

        $fileName = $file->getClientOriginalName();
        $prefix = explode('-', $fileName)[0];
        $orderType = OrderType::findByName($prefix);
       //dd($orderType);

        if ($orderType) {
            //echo $orderType;
            $orderType = "0" . $orderType;

        }

        if (!$orderType) {
            return redirect()->back()->with("toast_error", "Invalid order type.");
        }

        $currentMonthYear = Carbon::now()->format('my');
        $formattedUserId = strlen($userId) === 1 ? '0' . $userId : $userId;

        $currentDate = Carbon::now()->toDateString();
        $orderCount = DB::table('orders')
            ->where('order_type', $orderType)
            ->whereDate('created_at', $currentDate)
            ->count();

        do {
    $nextSequence = $orderCount + 1;
    $orderNumber = sprintf("%s/%s/%s/%03d", $formattedUserId, $orderType, $currentMonthYear, $nextSequence);

    $exists = DB::table('orders')->where('order_number', $orderNumber)->exists();
    $orderCount++;
        } while ($exists);
            # code...

        // Create empty order to get ID but we�ll roll back if anything fails
        $orderId = DB::table('orders')->insertGetId([
            'order_number' => $orderNumber,
            'prefix'       => $prefix,
            'order_type'   => $orderType,
            'created_by'   => $userId,
            'file_name'    => $fileName,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ]);

    // Attempt to import the Excel file
        Excel::import(new InventorystocksImport($orderId), $file);

        // If import succeeds, commit
        DB::commit();

        // Send mail
        //$email = 'samirsing@gmail.com';
       // Mail::to($email)->send(new POUploadedMail($email));
	   // Step 4: Send email after success
        $hardcodedEmail = 'tanubasuchoudhury1997@gmail.com';
        Mail::to($hardcodedEmail)->send(new POUploadedMail($orderNumber));

        return redirect()->route('admin.is_upload.preview')
            ->with("toast_success", "IS report uploaded and mail sent.");


      //  return redirect()->route('admin.po_upload.preview');
    } catch (\Exception $ex) {
        DB::rollBack(); // Undo DB changes
        \Log::error("Error Creating Order: " . $ex->getMessage());
        return redirect()->back()->with("toast_error", $ex->getMessage());
    }
}




public function storffff(Request $request)
{
    try {
        $userId = Auth::id(); // Get authenticated user ID
        $file = $request->file('select_is_template');

        if (!$file) {
            return redirect()->back()->with("toast_error", "No file uploaded.");
        }

        $fileName = $file->getClientOriginalName();
        $prefix = explode('-', $fileName)[0];
        $orderType = OrderType::findByName($prefix);

        // Append 0 in orderType if found
        if ($orderType) {
            $orderType = "0" . $orderType;
        }

        \Log::info("IS Upload - OrderType: " . $orderType);

        if (!$orderType) {
            return redirect()->back()->with("toast_error", "Invalid order type.");
        }

        $currentMonthYear = Carbon::now()->format('my');
        $formattedUserId = strlen($userId) === 1 ? '0' . $userId : $userId;
        $currentDate = Carbon::now()->toDateString();

        // Count existing orders for today and order type
        $orderCount = DB::table('orders')
            ->where('order_type', $orderType)
            ->whereDate('created_at', $currentDate)
            ->count();

        \Log::info("IS Upload - Order Count Today: " . $orderCount);

        $nextSequence = $orderCount + 1;

        // Create unique order number
        $orderNumber = sprintf("%s/%s/%s/%03d", $formattedUserId, $orderType, $currentMonthYear, $nextSequence);

        // Insert order and get its ID
        $orderId = DB::table('orders')->insertGetId([
            'order_number' => $orderNumber,
            'prefix'       => $prefix,
            'order_type'   => $orderType,
            'created_by'   => $userId,
            'file_name'    => $fileName,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ]);

        \Log::info("IS Upload - Created Order ID: " . $orderId . ", Order Number: " . $orderNumber);
        \Log::info("IS Upload - Starting Excel import for order ID: " . $orderId);

        // Import Excel using correct import class
        Excel::import(new InventorystocksImport($orderId), $file);

        \Log::info("IS Upload - Excel import completed for order ID: " . $orderId);

        // Redirect to preview page on success
        return redirect()->route('admin.is_upload.preview')
            ->with("toast_success", "IS report uploaded successfully.");

    } catch (\Exception $ex) {
        \Log::error("IS Upload - Error Creating Order: " . $ex->getMessage());
        return redirect()->back()->with("toast_error", $ex->getMessage());
    }
}




    public function export(Request $request)

    {


        return Excel::download(
        new InventoryStock,
        'IS-detail-' . date('Ymdhis') . '.xlsx'
    );
    }



    public function preview(Request $request)
{
    $data['results'] = DB::table('inventorystock_preview as ip')
        ->select('ip.*', 'p.MOQ')
        ->join('products as p', DB::raw("p.partcode COLLATE utf8mb4_unicode_ci"), '=', 'ip.productid')
        ->paginate(10);

    $data['menu'] = $this->menu;
    return view('admin.is-preview.index', $data);
}


    public function finalSubmit(Request $request)
    {
        $inventorystocks= DB::table('inventorystock_preview')->get();

        if($inventorystocks->count() > 0) {
            foreach($inventorystocks as $row)
            {
                DB::table('inventory_stocks')->insert([
                    'distributorid' => $row->distributorid,
                    'productid' => $row->productid,
                    'ordertime' => $row->ordertime,
                    'orderprice' => $row->orderprice,
                    // '+' => $row->orderqty,
                    'updatedtime' => Carbon::now(),
                    'excelid' => 'IS Import',
                    'status' => 'true',
                    'orderid' => $row->orderid,
                    'created_by' => $row->created_by,
                    'inventory_stock'=>$row->inventory_stock
                ]);
                //update order table set updatedtime = now() where id = $row->orderid
                DB::table('orders')->where('id', $row->orderid)->update([
                    'updated_at' => DB::raw('NOW()'),
                    'updated_by' => Auth::id(),
                ]);
            }
            DB::table('inventorystock_preview')->truncate();
        }

        return redirect()->route('admin.inventorystock.index')->with("toast_success", 'Inventory Stock  Imported Successfully!');
    }
}
