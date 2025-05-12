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
namespace App\Http\Controllers\Admin\SubCategories;
use App\Http\Controllers\Controller;
use App\Models\Admin\SubCategories\SubCategories as SubCategories;
use App\Requests\Admin\SubCategories\SubCategoriesRequestExtended as SubCategoriesRequest;
use Illuminate\Support\Facades\Gate;
class SubCategoriesController extends Controller
{   
    public array $menu = ["item" =>"sub_categories", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['sub_categories_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $sub_categories_list_all = SubCategories::startSearch(Request()->query("sub_categories_search"))->orderByDesc("id")->get();
       

  
         return view("admin.subCategories.index")->with(compact('menu','sub_categories_list_all'))->fragmentIf(Request()->ajax_call==1, "sub_categories_fragment");
    }

    public function create()
    {
        if (Gate::none('sub_categories_create')) {
            abort(403); 
        }
        $menu = $this->menu;
        $data = new SubCategories();
        
        return view("admin.subCategories.form")->with(compact('menu','data'));
    }

    public function store(SubCategoriesRequest $request)
    {
        if (Gate::none('sub_categories_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = SubCategories::create($requestAll);
        

        return redirect(route("admin.sub_categories.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('sub_categories_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = SubCategories::findOrFail(request()->route()->categories_id);;
        
        return view("admin.subCategories.form")->with(compact('menu', 'data'));
    }

    public function update(CategoriesRequest $request)
    {
        if (Gate::none('sub_categories_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = SubCategories::findOrFail(request()->route()->categories_id);
        $run->update($requestAll);
        return redirect(route("admin.sub_categories.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('sub_categories_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        SubCategories::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.sub_categories.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
