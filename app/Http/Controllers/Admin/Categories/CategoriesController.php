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
namespace App\Http\Controllers\Admin\Categories;
use App\Http\Controllers\Controller;
use App\Models\Admin\Categories\CategoriesExtended as Categories;
use App\Requests\Admin\Categories\CategoriesRequestExtended as CategoriesRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\SubCategories\SubCategories;
use Illuminate\Http\Request;
class CategoriesController extends Controller
{   
    public array $menu = ["item" =>"categories", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['categories_access'])) {
            abort(403);
        }
		$menu = $this->menu;


        $categories_list_all = Categories::startSearch(Request()->query("categories_search"))->orderByDesc("id")->get();
		//dd($categories_list_all );
        return view("admin.categories.index")->with(compact('menu','categories_list_all'))->fragmentIf(Request()->ajax_call==1, "categories_fragment");
    }

    public function create()
    {
        if (Gate::none('categories_create')) {
            abort(403);
        }
        $menu = $this->menu;
		 $parentCategories = Categories::whereNull('catid')->get();  // Get categories without parents

        $data = new Categories();
        
        return view("admin.categories.form")->with(compact('menu','data','parentCategories'));
    }

    public function store(CategoriesRequest $request)
    {
        if (Gate::none('categories_create')) {
            abort(403);
        }
        $requestAll = $request->all();
		 // Check if parent category is selected, assign the parent_id for subcategory
    if ($request->has('catid') && $request->catid) {
        $requestAll['catid'] = $request->catid;
    }
        $run = Categories::create($requestAll);
        

        return redirect(route("admin.categories.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('categories_edit')) {
            abort(403);
        }
        $menu = $this->menu;
       // $data = Categories::findOrFail(request()->route()->categories_id);;
        
       // return view("admin.categories.form")->with(compact('menu', 'data'));

		  $data = Categories::findOrFail(request()->route()->categories_id);

    // Don't include the current category itself as a parent option
    $parentCategories = Categories::where('id', '!=', $data->id)->whereNull('catid')->get();

    return view("admin.categories.form")->with(compact('menu', 'data', 'parentCategories'));
    }

    public function update(CategoriesRequest $request)
    {
        if (Gate::none('categories_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Categories::findOrFail(request()->route()->categories_id);
        $run->update($requestAll);
        return redirect(route("admin.categories.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('categories_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Categories::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.categories.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }

	 public function categories_auto_complete()
    {
        if(Request()->has('q')){
            $data = SubCategories::select("id","name")
            ->orWhere("name","LIKE","%".Request()->q."%")
            ->limit(50)->get()->sortBy("id");
        } else {
            $data = SubCategories::select("id","name")->limit(50)->get()->sortBy("id");
        }
        $return = $data->map(function ($item) {
            return ['id' => $item->id,'text' => $item->name." "];
        });
        return response()->json($return);
    }

	
    
}
