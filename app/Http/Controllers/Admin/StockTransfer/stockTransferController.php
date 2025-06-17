<?php
namespace App\Http\Controllers\Admin\StockTransfer;
use App\Models\Admin\Stocktransfer\Stocktransfer;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use DB;

class stockTransferController extends Controller
{
    public array $menu = ["item"=>"stock_transfer", "sub_folder"=>"", "folder"=>""];
  public function index()
{
    if (!Gate::allows('stock_transfer_access')) {
        abort(403);
    }

    $menu = $this->menu;

    // Raw SQL query using JOINs
     $stock_transfer_list = DB::table('stock_transfer as s')
        ->leftJoin('categories as c', 's.category_id', '=', 'c.id')
        ->leftJoin('brands as b', 's.brand_id', '=', 'b.id')
        ->leftJoin('sub_categories as sc', 's.subcategory_id', '=', 'sc.id')
        ->select(
            's.*',
            'c.catname as catname',
            'b.brandname as brandname',
            'sc.name as name'
        )->get();

   // dd($stock_transfer_list);
   return view('admin.stock_transfer.index')->with(compact('menu','stock_transfer_list'));

}
    public function create()
    {
        if (Gate::none('stock_transfer_create')) {
            abort(403);
        }
        $menu= $this->menu;
        $data =  new stocktransfer();
        return view('admin.stocktransfer.form')->with(compact('menu','data'));
    }
    public function store(Request $request)
    {
         if (Gate::none('stock_transfer_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = stocktransfer::create($requestAll);
        return redirect()->route('admin.stocktransfer.index')>with("toast_success", trans('admin/misc.success_confirmation_created'));

    }
    public function show()
    {
        abort(404);
    }
    public function edit()
    {
        if (Gate::none('stock_transfer_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = stocktransfer::findOrFail(request()->route()->stocktransfer_id);;

        return view("admin.stocktransfer.form")->with(compact('menu', 'data'));
    }

    public function update(Request $request)
    {
        if (Gate::none('brands_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
 $run = stocktransfer::findOrFail(request()->route()->stocktransfer_id);
        $run->update($requestAll);
        return redirect(route("admin.stocktransfer.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('stock_transfer_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        stocktransfer::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.stocktransfer.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
}
