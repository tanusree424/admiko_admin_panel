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
namespace App\Http\Controllers\Admin\AdminTeams;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminTeams\AdminTeams;
use App\Requests\Admin\AdminTeams\AdminTeamsRequest;
use Illuminate\Support\Facades\Gate;
class AdminTeamsController extends Controller
{   
    public array $menu = ["item" =>"admin_teams", "folder" =>"admin_settings", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['admin_teams_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $admin_teams_list_all = AdminTeams::startSearch(Request()->query("admin_teams_search"))->orderBy("name")->get();
        return view("admin.admin_teams.index")->with(compact('menu','admin_teams_list_all'));
    }

    public function create()
    {
        if (Gate::none('admin_teams_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new AdminTeams();
        
        return view("admin.admin_teams.form")->with(compact('menu','data'));
    }

    public function store(AdminTeamsRequest $request)
    {
        if (Gate::none('admin_teams_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = AdminTeams::create($requestAll);
        

        return redirect(route("admin.admin_teams.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        if (Gate::none('admin_teams_show')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = AdminTeams::findOrFail(request()->route()->admin_teams_id);
        
        return view("admin.admin_teams.show")->with(compact('menu', 'data'));
    }

    public function edit()
    {
        if (Gate::none('admin_teams_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = AdminTeams::findOrFail(request()->route()->admin_teams_id);;
        
        return view("admin.admin_teams.form")->with(compact('menu', 'data'));
    }

    public function update(AdminTeamsRequest $request)
    {
        if (Gate::none('admin_teams_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = AdminTeams::findOrFail(request()->route()->admin_teams_id);
        $run->update($requestAll);
        return redirect(route("admin.admin_teams.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('admin_teams_delete')) {
            abort(403);
        }
        AdminTeams::destroy(Request()->delete_id);
        return redirect(route("admin.admin_teams.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
    }
    
}
