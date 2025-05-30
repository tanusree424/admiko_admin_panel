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
namespace App\Http\Controllers\Admin\Purchaseorders;
use App\Models\Admin\Purchaseorders\PurchaseordersExtended as Purchaseorders;
use App\Exports\PoFilteredExport;
use App\Models\Admin\Orders\Orders;
use Excel;
use Auth;

class PurchaseordersControllerExtended extends PurchaseordersController
{

public function index()
{
    $LoggedInUserRole = Auth::user()->rolesMany()->first()->title; 
    $userid = Auth::id();
    $menu = $this->menu;
   // dd($userid);
    // Start building the query
    $query = Orders::select('orders.*', 'admin_users.name as admin_name', 'admin_users.id as admin_id')
                    ->join('admin_users', 'orders.created_by', '=', 'admin_users.id')
                    ->where('orders.prefix',"=","PO")
                    ->where('orders.enabled', '=', 1)
                    ->orderBy('orders.created_at', 'desc');

    // Apply user filter if not Administrator
    if ($LoggedInUserRole != 'Administator') {
        $query->where('orders.created_by', $userid);
    }

    // Apply date filters if present
    if (!empty($_REQUEST['date_start']) && !empty($_REQUEST['date_end'])) {
        $query->whereDate('orders.created_at', '>=', $_REQUEST['date_start']);
        $query->whereDate('orders.created_at', '<=', $_REQUEST['date_end']);
    }

    $purchaseorders_list_all = $query->get();

    // Assuming you are using Laravel's Auth system
    //$user = auth()->user();
    //$LoggedInUserRole = $user->role ?? 'Guest'; // Adjust as per your app's logic


    return view("admin.purchaseorders.index")
        ->with(compact('menu', 'purchaseorders_list_all','LoggedInUserRole','userid'))
        ->fragmentIf(request()->ajax_call == 1, "purchaseorders_fragment");
}


    public function index_old()
    {
        $LoggedInUserRole = Auth::user()->rolesMany()->first()->title; 
        $userid = Auth::id(); // To Get User ID
		$menu = $this->menu;
        $purchaseorders_list_all;


        if(!empty($_REQUEST['date_start']) && !empty($_REQUEST['date_end'])) {
            $query->whereDate('created_at','>=',$_REQUEST['date_start']);
            $query->whereDate('created_at','<=',$_REQUEST['date_end']);
        }


        if($LoggedInUserRole == 'Administator') {
            $purchaseorders_list_all = Orders::findOrderByUserId(0);
        }else{
            $purchaseorders_list_all = Orders::findOrderByUserId($userid);
        }
      
        return view("admin.purchaseorders.index")->with(compact('menu','purchaseorders_list_all'))->fragmentIf(Request()->ajax_call==1, "purchaseorders_fragment");
    }

    public function _index()
    {
        $LoggedInUserRole = Auth::user()->rolesMany()->first()->title; // To Get User Role and view based on user selection

        $userid = Auth::id(); // To Get User ID

		$menu = $this->menu;

        $query = Purchaseorders::query();

        if(in_array($LoggedInUserRole,array('Sales Admin','Distributor'))) {
            $query->where('distributorid', Auth::id());
        }

        // if(!empty($_REQUEST['date_start']) && !empty($_REQUEST['date_end'])) {
        //     $query->whereDate('ordertime','>=',$_REQUEST['date_start']);
        //     $query->whereDate('ordertime','<=',$_REQUEST['date_end']);
        // }

       // $purchaseorders_list_all = $query->with('distributorInfo')->startSearch(Request()->query("purchaseorders_search"))->orderBy("id","Asc")->get();

    //    $purchaseorders_list_all = $query
    //    ->with(['distributorInfo', 'product']) // Load product relation
    //    ->startSearch(Request()->query("purchaseorders_search"))
    //    ->orderBy("id", "Asc")
    //    ->get();

        $purchaseorders_list_all = Orders::findOrderByUserId($userid);

        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Export') {
            return Excel::download(new PoFilteredExport($purchaseorders_list_all), 'PurchaseOrders-'.time().'.xlsx');
        }
        return view("admin.purchaseorders.index")->with(compact('menu','purchaseorders_list_all'))->fragmentIf(Request()->ajax_call==1, "purchaseorders_fragment");
    }

    
}
