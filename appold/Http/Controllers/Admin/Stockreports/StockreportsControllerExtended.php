<?php

namespace App\Http\Controllers\Admin\Stockreports;
use App\Models\Admin\Stockreports\StockreportsExtended as Stockreports;
use Auth;
use App\Models\Admin\Orders\Orders;
use Excel;

class StockreportsControllerExtended extends StockreportsController
{

    public function index()
    {
        $LoggedInUserRole = Auth::user()->rolesMany()->first()->title; 
        $userid = Auth::id();
        $menu = $this->menu;
    
        // Start building the query
        $query = Orders::select('orders.*', 'admin_users.name as admin_name', 'admin_users.id as admin_id')
                        ->join('admin_users', 'orders.created_by', '=', 'admin_users.id')
                        ->where('orders.prefix', "=", 'Stock')
                        ->where('orders.enabled', "=", '1')
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
    
        $stockreports_list_all = $query->get();
    
        return view("admin.stockreports.index")
            ->with(compact('menu', 'stockreports_list_all','LoggedInUserRole'))
            ->fragmentIf(request()->ajax_call == 1, "stockreports_fragment");
    }
}
