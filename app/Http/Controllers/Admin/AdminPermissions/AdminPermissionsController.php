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
namespace App\Http\Controllers\Admin\AdminPermissions;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminPermissions\AdminPermissions;
use App\Requests\Admin\AdminPermissions\AdminPermissionsRequest;
use Illuminate\Support\Facades\Gate;
class AdminPermissionsController extends Controller
{   
    public array $menu = ["item" =>"admin_permissions", "folder" =>"admin_settings", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['admin_permissions_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $admin_permissions_list_all = AdminPermissions::startSearch(Request()->query("admin_permissions_search"))->orderBy("title")->orderBy("permission_slug")->get();
        return view("admin.admin_permissions.index")->with(compact('menu','admin_permissions_list_all'));
    }

    public function create()
    {
        if (Gate::none('admin_permissions_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new AdminPermissions();
        
        return view("admin.admin_permissions.form")->with(compact('menu','data'));
    }

    public function store(AdminPermissionsRequest $request)
    {
        if (Gate::none('admin_permissions_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = AdminPermissions::create($requestAll);
        

        return redirect(route("admin.admin_permissions.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('admin_permissions_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = AdminPermissions::findOrFail(request()->route()->admin_permissions_id);;
        
        return view("admin.admin_permissions.form")->with(compact('menu', 'data'));
    }

    public function update(AdminPermissionsRequest $request)
    {
        if (Gate::none('admin_permissions_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = AdminPermissions::findOrFail(request()->route()->admin_permissions_id);
        $run->update($requestAll);
        return redirect(route("admin.admin_permissions.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('admin_permissions_delete')) {
            abort(403);
        }
        AdminPermissions::destroy(Request()->delete_id);
        return redirect(route("admin.admin_permissions.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
    }
    
}
