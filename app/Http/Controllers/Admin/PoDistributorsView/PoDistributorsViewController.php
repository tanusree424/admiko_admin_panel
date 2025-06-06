<?php

namespace App\Http\Controllers\Admin\PoDistributorsView;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Admin\AdminService\Traits\AdminHelperTrait;
use App\Models\Admin\Products\Products;
use App\Models\Admin\Purchaseorders\Purchaseorders;
use App\Models\Admin\AdminService\Auth\AuthUser;
use App\Models\Admin\Stockreports\StockreportsExtended as Stockreports;
use App\Exports\PoDistributorExport;
use Excel;
use DB;

class PoDistributorsViewController extends Controller
{
	use AdminHelperTrait;

    public array $menu = ["item" =>"po_distributors_view", "folder" =>"po_distributors_view", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['po_distributors_view_access'])) {
            abort(403);
        }

        $menu = $this->menu;

        $productsList = Products::paginate(10);

        $distributorOrdered = DB::table('purchaseorders as po')
        ->select('po.productid','po.orderqty','po.distributorid','u.name')
        ->join('admin_users as u','po.distributorid','=','u.id')
        ->when(!empty($_REQUEST['date_start']), function ($query) {
            $query->whereDate('po.ordertime','>=',$_REQUEST['date_start']);
        })
        ->when(!empty($_REQUEST['date_end']), function ($query) {
            $query->whereDate('po.ordertime','<=',$_REQUEST['date_end']);
        })
        ->get();

        $stockInfo = Stockreports::query();

        if(!empty($_REQUEST['date_start']) && !empty($_REQUEST['date_end'])) {
            $stockInfo->whereDate('created_at','>=',$_REQUEST['date_start']);
            $stockInfo->whereDate('created_at','<=',$_REQUEST['date_end']);
        }

        $stockData = $stockInfo->with('userInfo')->select('distributorid','productid','stockinhand')->get();

        $distributors = array();
        $orderedQtyPrdWise = array();
        $orderedQtyDistWise = array();
        $totalStock = array();
        $adminStock = array();
        $otherStock = array();
        $prdwiseQty = 0;

        if($stockData->count() > 0) {
            foreach($stockData as $stock) {
                $userType = $stock->userInfo->rolesMany()->first()->title;
                if(!isset($adminStock[$stock->productid]) && $userType == 'Administator') {
                    $adminStock[$stock->productid] = 0;
                }

                if(!isset($otherStock[$stock->productid])) {
                    $otherStock[$stock->productid] = 0;
                }

                if(in_array($userType,array('Administator'))) {
                    $adminStock[$stock->productid] += $stock->stockinhand;
                } else {
                    $otherStock[$stock->productid] = $stock->stockinhand;
                }

            }
        }

        if($distributorOrdered->count() > 0) {
            foreach($distributorOrdered as $ordata) {
                $distributors[$ordata->distributorid] = $ordata->name;
                if(!isset($orderedQtyDistWise[$ordata->productid][$ordata->distributorid])) {
                    $orderedQtyDistWise[$ordata->productid][$ordata->distributorid] = 0;
                }
                $orderedQtyDistWise[$ordata->productid][$ordata->distributorid] += $ordata->orderqty;
                if(!isset($orderedQtyPrdWise[$ordata->distributorid])) {
                    $orderedQtyPrdWise[$ordata->distributorid] = 0;
                }
                //$prdwiseQty += $ordata->orderqty;
                $orderedQtyPrdWise[$ordata->distributorid] += $ordata->orderqty;
            }
        }

        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'Export') {
            return Excel::download(new PoDistributorExport($productsList,$distributors,$orderedQtyDistWise,$orderedQtyPrdWise,$adminStock,$otherStock), 'PO-Distributor-View-'.time().'.xlsx');
        }

        return view("admin.po_distributors_view.index")->with(compact('menu','productsList','distributors','orderedQtyDistWise', 'orderedQtyPrdWise','adminStock','otherStock'));
    }

}
