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
namespace App\Http\Controllers\Admin\UploadSalesReport;
use Illuminate\Http\Request;
use App\Imports\salesReportImport;
use App\Exports\salesReportExports;
use Excel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Admin\OrderType\OrderType;
use DB;

class UploadSalesReportControllerExtended extends UploadSalesReportController
{
    public function store(Request $request)


{
    try {
        $userId = Auth::id();
        $file = $request->file('sales_report_template_upload');

        if (!$file) {
            return redirect()->back()->with("toast_error", "No file uploaded.");
        }

        $fileName = $file->getClientOriginalName();
        $prefix = explode('-', $fileName)[0];
        $orderType = OrderType::findByName($prefix);

        if (!$orderType) {
            return redirect()->back()->with("toast_error", "Invalid order type.");
        }

        $orderTypeFormatted = "0" . $orderType;
        $currentMonthYear = Carbon::now()->format('my');
        $formattedUserId = strlen($userId) === 1 ? '0' . $userId : $userId;
        $currentDate = Carbon::now()->toDateString();

        // Step 1: Validate the Excel (using a dummy orderId = 0)
        try {
            Excel::import(new salesReportImport(0), $file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = $e->failures();
            $errorMessages = [];

            foreach ($errors as $failure) {
                $errorMessages[] = "Row {$failure->row()}: {$failure->errors()[0]}";
            }

            return redirect()->back()->with("toast_error", 'Validation failed: ' . implode(', ', $errorMessages));
        }

        // Step 2: Create order only after successful validation
        $orderCount = DB::table('orders')
            ->where('order_type', $orderTypeFormatted)
            ->whereDate('created_at', $currentDate)
            ->count();

        $nextSequence = $orderCount + 1;
        $orderNumber = sprintf("%s/%s/%s/%03d", $formattedUserId, $orderTypeFormatted, $currentMonthYear, $nextSequence);

        $orderId = DB::table('orders')->insertGetId([
            'order_number' => $orderNumber,
            'prefix'       => $prefix,
            'order_type'   => $orderTypeFormatted,
            'created_by'   => $userId,
            'file_name'    => $fileName,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ]);

        DB::table('orders')->where('id', $orderId)->update([
            'updated_at' => DB::raw('NOW()'),
            'updated_by' => $userId,
        ]);

        // Step 3: Import again, now with real orderId
        Excel::import(new salesReportImport($orderId), $file);

        return redirect()->back()->with("toast_success", 'Sales Report imported successfully!');
    } catch (\Exception $ex) {
        \Log::error($ex);
        return redirect()->back()->with("toast_error", 'Sales Report import failed! ' . $ex->getMessage());
    }
}

    public function storeprev(Request $request)
    {
        try {
            $userId = Auth::id(); // Retrieves the ID of the currently authenticated user
            $file = $request->file('sales_report_template_upload');
    
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
    
            // Get the current date at 00:00:00
            $currentDate = Carbon::now()->toDateString();
    
            // Count the number of orders for the current date and `order_type`
            $orderCount = DB::table('orders')
                ->where('order_type', $orderType)
                ->whereDate('created_at', $currentDate)
                ->count();
    
            // Determine the next sequence number
            $nextSequence = $orderCount + 1;
    
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
    
            // Update the order table with `updated_by`
            DB::table('orders')->where('id', $orderId)->update([
                'updated_at' => DB::raw('NOW()'),
                'updated_by' => Auth::id(),
            ]);
    
            // Import the sales report using Excel
            Excel::import(new salesReportImport($orderId), $file);
            // Excel::import(new salesReportImport($orderId), $request->file('sales_report_template_upload'));
    
            return redirect()->back()->with("toast_success", 'Sales Report imported successfully!');
        } catch (\Exception $ex) {
            \Log::info($ex);
            return redirect()->back()->with("toast_error", 'Sales Report imported Failed! ' . $ex->getMessage());
        }
    }

    public function storeOld(Request $request)
    {
        try{

            $userId = Auth::id(); // Retrieves the ID of the currently authenticated user
            $file = $request->file('sales_report_template_upload');

            if (!$file) {
                return redirect()->back()->with("toast_error", "No file uploaded.");
            }

            $fileName = $file->getClientOriginalName();
            $prefix = explode('-', $fileName)[0];
            $orderType = OrderType::findByName($prefix);
            //Append 0 in orderType
            if ($orderType) {
                $orderType = "0" . $orderType;
            }
            \Log::error("orderType:::::::::::::::::> " . $orderType);

            if (!$orderType) {
                return redirect()->back()->with("toast_error", "Invalid order type.");
            }

            $currentMonthYear = Carbon::now()->format('my');

              // Check if the length of the user ID is 1 and store it in another variable
              if (strlen($userId) === 1) {
                $formattedUserId = '0' . $userId; // Prepend 0
            } else {
                $formattedUserId = $userId; // Keep the original value
            }

            $currentDate = Carbon::now()->startOfDay(); // Get the current date at 00:00:00
            $latestOrder = DB::table('orders')
            ->where('order_number', 'like', "{$formattedUserId}/{$orderType}/{$currentMonthYear}/%")
            ->where('updated_at', '>=', $currentDate) // Only consider orders from today
            ->orderBy('order_number', 'desc')
            ->first();

        if ($latestOrder) {
            $lastSequence = (int) substr($latestOrder->order_number, strrpos($latestOrder->order_number, '/') + 1);
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 001;
        }

        $orderNumber = sprintf("%s/%s/%s/%03d",$formattedUserId, $orderType, $currentMonthYear, $nextSequence);
         // Insert the new order and retrieve its ID
        $orderId = DB::table('orders')->insertGetId([
            'order_number' => $orderNumber,
            'prefix'       => $prefix,
            'order_type'   => $orderType,
            'created_by'   => $userId,
            'file_name'    => $fileName,
            // Add other fields as necessary
        ]);

         //update order table set updatedtime = now() where id = $row->orderid
         DB::table('orders')->where('id', $orderId)->update([
            'updated_at' => DB::raw('NOW()'),
            'updated_by' => Auth::id(),
        ]);

            // Excel::import(new salesReportImport, $request->file('sales_report_template_upload'));
            Excel::import(new salesReportImport($orderId), $file);
            return redirect()->back()->with("toast_success", 'Sales Report imported successfully!');
        }catch(\Exception $ex){
            \Log::info($ex);
            return redirect()->back()->with("toast_error", 'Sales Report imported Failed!' . $ex->getMessage());

        }
    }


    // public function store(Request $request)
    // {
    //     try{

    //         Excel::import(new salesReportImport, $request->file('sales_report_template_upload'));
    //         return redirect()->back()->with("toast_success", 'Sales Report imported successfully!');
    //     }catch(\Exception $ex){
    //         \Log::info($ex);
    //         return redirect()->back()->with("toast_error", 'Sales Report imported Failed!');

    //     }
    // }

    public function export(Request $request)
    {
        return Excel::download(new salesReportExports, 'Sales-Report-'.date('Ymdhis').'.xlsx');
    }
}
