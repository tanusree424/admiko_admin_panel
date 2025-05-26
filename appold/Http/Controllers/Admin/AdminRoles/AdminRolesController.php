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
namespace App\Http\Controllers\Admin\AdminRoles;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminRoles\AdminRoles;
use App\Requests\Admin\AdminRoles\AdminRolesRequest;
use Illuminate\Support\Facades\Gate;
class AdminRolesController extends Controller
{   
    public array $menu = ["item" =>"admin_roles", "folder" =>"admin_settings", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['admin_roles_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $admin_roles_list_all = AdminRoles::startSearch(Request()->query("admin_roles_search"))->orderBy("id")->get();
        return view("admin.admin_roles.index")->with(compact('menu','admin_roles_list_all'));
    }

    public function create()
    {
        if (Gate::none('admin_roles_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new AdminRoles();
        
        return view("admin.admin_roles.form")->with(compact('menu','data'));
    }

    public function store(AdminRolesRequest $request)
    {
        if (Gate::none('admin_roles_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = AdminRoles::create($requestAll);
        
		$run->usersMany()->sync(Request()->input("users", []));
		$run->permissionsMany()->sync(Request()->input("permissions", []));

        return redirect(route("admin.admin_roles.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('admin_roles_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = AdminRoles::findOrFail(request()->route()->admin_roles_id);;
        
        return view("admin.admin_roles.form")->with(compact('menu', 'data'));
    }

    public function update(AdminRolesRequest $request)
    {
        if (Gate::none('admin_roles_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = AdminRoles::findOrFail(request()->route()->admin_roles_id);
		$run->usersMany()->sync(Request()->input("users", []));
		$run->permissionsMany()->sync(Request()->input("permissions", []));
        $run->update($requestAll);
        return redirect(route("admin.admin_roles.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('admin_roles_delete')) {
            abort(403);
        }
        if(in_array(1,Request()->delete_id)){
            return back()->with("toast_alert", trans("admin/misc.administrator_role_delete_error"));
        }
        AdminRoles::destroy(Request()->delete_id);
        return redirect(route("admin.admin_roles.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
    }
    
}
