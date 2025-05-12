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
namespace App\Http\Controllers\Admin\Productstocklogs;
use App\Http\Controllers\Controller;
use App\Models\Admin\Productstocklogs\Productstocklogs;
use App\Requests\Admin\Productstocklogs\ProductstocklogsRequest;
use Illuminate\Support\Facades\Gate;
class ProductstocklogsController extends Controller
{   
    public array $menu = ["item" =>"productstocklogs", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['productstocklogs_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $productstocklogs_list_all = Productstocklogs::startSearch(Request()->query("productstocklogs_search"))->orderByDesc("id")->get();
        return view("admin.productstocklogs.index")->with(compact('menu','productstocklogs_list_all'))->fragmentIf(Request()->ajax_call==1, "productstocklogs_fragment");
    }

    public function create()
    {
        if (Gate::none('productstocklogs_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Productstocklogs();
        
        return view("admin.productstocklogs.form")->with(compact('menu','data'));
    }

    public function store(ProductstocklogsRequest $request)
    {
        if (Gate::none('productstocklogs_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Productstocklogs::create($requestAll);
        

        return redirect(route("admin.productstocklogs.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('productstocklogs_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Productstocklogs::findOrFail(request()->route()->productstocklogs_id);;
        
        return view("admin.productstocklogs.form")->with(compact('menu', 'data'));
    }

    public function update(ProductstocklogsRequest $request)
    {
        if (Gate::none('productstocklogs_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Productstocklogs::findOrFail(request()->route()->productstocklogs_id);
        $run->update($requestAll);
        return redirect(route("admin.productstocklogs.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('productstocklogs_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Productstocklogs::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.productstocklogs.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
