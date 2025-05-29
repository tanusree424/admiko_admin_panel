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
namespace App\Http\Controllers\Admin\inventorystock;
use App\Models\Admin\inventoryStock\inventorystocksExtended as inventorystocks;
use App\Exports\ISFilteredExport;
use App\Models\Admin\Orders\Orders;
use Excel;
use Auth;
use Illuminate\Http\Request;
class inventorystockControllerExtended extends inventoryStockController
{



public function index(Request $request)
{
    $LoggedInUserRole = Auth::user()->rolesMany()->first()->title;
    $userid = Auth::id();
    $menu = $this->menu;

    $query = Orders::select('orders.*', 'admin_users.name as admin_name', 'admin_users.id as admin_id')
                    ->join('admin_users', 'orders.created_by', '=', 'admin_users.id')
                    ->where('orders.prefix', "=", "IS")
                    ->where('orders.enabled', '=', 1)
                    ->orderBy('orders.created_at', 'desc');

    if ($LoggedInUserRole != 'Administator') {
        $query->where('orders.created_by', $userid);
    }

    if (!empty($request->date_start) && !empty($request->date_end)) {
        $query->whereDate('orders.created_at', '>=', $request->date_start);
        $query->whereDate('orders.created_at', '<=', $request->date_end);
    }

    $inventorystocks_list_all = $query->get();

    return view("admin.inventorystocks.index")
        ->with(compact('menu', 'inventorystocks_list_all', 'LoggedInUserRole', 'userid'))
        ->fragmentIf($request->ajax_call == 1, "inventorystocks_fragment");
}


    public function index_old()
    {
        $LoggedInUserRole = Auth::user()->rolesMany()->first()->title;
        $userid = Auth::id(); // To Get User ID
		$menu = $this->menu;
        $inventorystocks_list_all;


        if(!empty($_REQUEST['date_start']) && !empty($_REQUEST['date_end'])) {
            $query->whereDate('created_at','>=',$_REQUEST['date_start']);
            $query->whereDate('created_at','<=',$_REQUEST['date_end']);
        }


        if($LoggedInUserRole == 'Administator') {
            $inventorystocks_list_all = Orders::findOrderByUserId(0);
        }else{
            $inventorystocks_list_all = Orders::findOrderByUserId($userid);
        }

        return view("admin.inventorystocks.index")->with(compact('menu','inventorystocks_list_all'))->fragmentIf(Request()->ajax_call==1, "inventorystockss_fragment");
    }

    public function _index()
    {
        $LoggedInUserRole = Auth::user()->rolesMany()->first()->title; // To Get User Role and view based on user selection

        $userid = Auth::id(); // To Get User ID

		$menu = $this->menu;

        $query = inventorystocks::query();

        if(in_array($LoggedInUserRole,array('Sales Admin','Distributor'))) {
            $query->where('distributorid', Auth::id());
        }

        // if(!empty($_REQUEST['date_start']) && !empty($_REQUEST['date_end'])) {
        //     $query->whereDate('ordertime','>=',$_REQUEST['date_start']);
        //     $query->whereDate('ordertime','<=',$_REQUEST['date_end']);
        // }

       // $inventorystockss_list_all = $query->with('distributorInfo')->startSearch(Request()->query("inventorystockss_search"))->orderBy("id","Asc")->get();

    //    $inventorystockss_list_all = $query
    //    ->with(['distributorInfo', 'product']) // Load product relation
    //    ->startSearch(Request()->query("inventorystockss_search"))
    //    ->orderBy("id", "Asc")
    //    ->get();

        $inventorystocks_list_all = Orders::findOrderByUserId($userid);

        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Export') {
            return Excel::download(new ISFilteredExport($inventorystocks_list_all), 'inventorystocks-'.time().'.xlsx');
        }
        return view("admin.inventorystocks.index")->with(compact('menu','inventorystocks_list_all'))->fragmentIf(Request()->ajax_call==1, "inventorystockss_fragment");
    }


}
