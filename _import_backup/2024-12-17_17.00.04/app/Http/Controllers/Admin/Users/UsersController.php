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
namespace App\Http\Controllers\Admin\Users;
use App\Http\Controllers\Controller;
use App\Models\Admin\Users\Users;
use App\Requests\Admin\Users\UsersRequest;
use Illuminate\Support\Facades\Gate;
class UsersController extends Controller
{   
    public array $menu = ["item" =>"users", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['users_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $users_list_all = Users::startSearch(Request()->query("users_search"))->orderByDesc("id")->get();
        return view("admin.users.index")->with(compact('menu','users_list_all'))->fragmentIf(Request()->ajax_call==1, "users_fragment");
    }

    public function create()
    {
        if (Gate::none('users_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Users();
        
        return view("admin.users.form")->with(compact('menu','data'));
    }

    public function store(UsersRequest $request)
    {
        if (Gate::none('users_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Users::create($requestAll);
        

        return redirect(route("admin.users.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('users_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Users::findOrFail(request()->route()->users_id);;
        
        return view("admin.users.form")->with(compact('menu', 'data'));
    }

    public function update(UsersRequest $request)
    {
        if (Gate::none('users_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Users::findOrFail(request()->route()->users_id);
        $run->update($requestAll);
        return redirect(route("admin.users.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('users_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Users::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.users.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
