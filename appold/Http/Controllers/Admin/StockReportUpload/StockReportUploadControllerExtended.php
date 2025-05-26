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
namespace App\Http\Controllers\Admin\StockReportUpload;
use Illuminate\Http\Request;
use App\Imports\stockReportImport;
use App\Exports\StockTemplate;
use App\Mail\POUploadedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\OrderType\OrderType;
use Carbon\Carbon;
use Auth;
use Excel;
use DB;

class StockReportUploadControllerExtended extends StockReportUploadController
{

public function store(Request $request)
{
    try {
        $userId = Auth::id();
        $file = $request->file('stock_report_file');

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

        // Step 1: Validate Excel WITHOUT inserting anything
        Excel::import(new stockReportImport(null, true), $file);

        // Step 2: Proceed to generate order number and insert only if validation passed
        $currentMonthYear = Carbon::now()->format('my');
        $formattedUserId = strlen($userId) === 1 ? '0' . $userId : $userId;
        $currentDate = Carbon::now()->toDateString();

        $orderCount = DB::table('orders')
            ->where('order_type', $orderType)
            ->whereDate('created_at', $currentDate)
            ->count();

        $nextSequence = $orderCount + 1;
        $orderNumber = sprintf("%s/%s/%s/%03d", $formattedUserId, $orderType, $currentMonthYear, $nextSequence);

        $orderId = DB::table('orders')->insertGetId([
            'order_number' => $orderNumber,
            'prefix'       => $prefix,
            'order_type'   => $orderType,
            'created_by'   => $userId,
            'file_name'    => $fileName,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ]);

        //  Step 3: Now do actual import with orderId
        Excel::import(new stockReportImport($orderId), $file);

		        // Step 4: Send email after success
        $hardcodedEmail = 'tanubasuchoudhury1997@gmail.com';
        Mail::to($hardcodedEmail)->send(new POUploadedMail($orderNumber));

        return redirect()->route('admin.stock_upload.preview')
            ->with("toast_success", "Stock report uploaded and mail sent.");


        

    } catch (\Exception $ex) {
        \Log::error("Error Creating Order: " . $ex->getMessage());
        return redirect()->back()->with("toast_error", $ex->getMessage());
    }
}

    public function storesss(Request $request)
{
    try {
        $userId = Auth::id(); // Retrieves the ID of the currently authenticated user
        $file = $request->file('stock_report_file');

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
        Excel::import(new stockReportImport($orderId), $file);
        // Excel::import(new stockReportImport, $request->file('stock_report_file'));

        return redirect()->route('admin.stock_upload.preview');
    } catch (\Exception $ex) {
        \Log::error("Error Creating Order: " . $ex->getMessage());
        return redirect()->back()->with("toast_error", $ex->getMessage());
    }
}

    // public function store(Request $request)
    // {
    //     try{
    //         Excel::import(new stockReportImport, $request->file('stock_report_file'));
    //         return redirect()->route('admin.stock_upload.preview');
    //     }catch(\Exception $ex){
    //         \Log::info($ex);
    //         return redirect()->back()->with("toast_error", $ex->getMessage());
    //     }
    // }

    public function export(Request $request)
    {
        return Excel::download(new StockTemplate, 'Stock-Report-'.date('Ymdhis').'.xlsx');
    }

    public function preview(Request $request)
    {
        $data['results'] = DB::table('stock_upload_preview')->paginate(10);
        $data['menu'] = $this->menu;
        return view('admin.stock-preview.index',$data);
    }

    public function finalSubmit(Request $request)
    {
        $stock = DB::table('stock_upload_preview')->get();

        if($stock->count() > 0) {
            foreach($stock as $row)
            {
                DB::table('stockreports')->insert(['distributorid' => Auth::id(),
                'productid' => $row->part_code,
                'stockinhand' => $row->stock_in_hand,
                'createdtime' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'orderid' => $row->orderid,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

             //update order table set updatedtime = now() where id = $row->orderid
             DB::table('orders')->where('id', $row->orderid)->update([
                'updated_at' => DB::raw('NOW()'),
                'updated_by' => Auth::id(),
            ]);

            }
            DB::table('stock_upload_preview')->truncate();
        }

        return redirect()->route('admin.stockreports.index')->with("toast_success", 'Stock Imported Successfully!');
    }
}
