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
namespace App\Http\Controllers\Admin\StockDistributorsView;

use App\Models\Admin\Products\Products;
use App\Models\Admin\Purchaseorders\Purchaseorders;
use App\Models\Admin\AdminService\Auth\AuthUser;
use DB;

class StockDistributorsViewControllerExtended extends StockDistributorsViewController
{
    public function index()
    {
        echo 'here';
        exit;
        if (Gate::none(['stock_distributors_view_access'])) {
            abort(403);
        }

        $menu = $this->menu;
        $productsList = Products::paginate(10);
        $distributorOrdered = DB::table('stockreports as po')
        ->select('po.productid','po.stockinhand as orderqty','po.distributorid','u.name')
        ->join('admin_users as u','po.distributorid','=','u.id')
        ->get();
        $stockInfo = DB::table('stockreports')->pluck('stock_in_hand','product_id');
        echo '<pre>';
        print_r($stockInfo);
        exit;
        $distributors = array();
        $orderedQtyPrdWise = array();
        $orderedQtyDistWise = array();
        $prdwiseQty = 0;
        foreach($distributorOrdered as $ordata) {
            $distributors[$ordata->distributorid] = $ordata->name;
            $orderedQtyDistWise[$ordata->productid][$ordata->distributorid] = $ordata->orderqty;
            //$prdwiseQty += $ordata->orderqty;
            $orderedQtyPrdWise[$ordata->distributorid][] = $ordata->orderqty;
        }
        return view("admin.stock_distributors_view.index")->with(compact('menu','productsList','distributors','orderedQtyDistWise', 'orderedQtyPrdWise'));
    }
}
