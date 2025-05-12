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
namespace App\Http\Controllers\Admin\AdminAuditableLogs;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminAuditableLogs\AdminAuditableLogs;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Admin\AdminService\Traits\AdminHelperTrait;
class AdminAuditableLogsController extends Controller
{   
	use AdminHelperTrait;

    public array $menu = ["item" =>"admin_auditable_logs", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['admin_auditable_logs_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $admin_auditable_logs_list_all = AdminAuditableLogs::startSearch(Request()->query("admin_auditable_logs_search"))->startSorting(Request())
			->paginate(Request()->query("admin_auditable_logs_length")??array_key_first(config("admin.table.table_length")),["*"], "admin_auditable_logs_page")
			->appends(["admin_auditable_logs_source" => "admin_auditable_logs"]);
		$admin_auditable_logs_list_all->table_action = $this->TableUrl(Request(),"admin_auditable_logs");
        return view("admin.admin_auditable_logs.index")->with(compact('menu','admin_auditable_logs_list_all'));
    }

    public function create()
    {
        abort(404);
    }

    public function store()
    {
        abort(404);
    }

    public function show()
    {
        if (Gate::none('admin_auditable_logs_show')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = AdminAuditableLogs::findOrFail(request()->route()->admin_auditable_logs_id);
        
        return view("admin.admin_auditable_logs.show")->with(compact('menu', 'data'));
    }

    public function edit()
    {
        abort(404);
    }

    public function update()
    {
        abort(404);
    }

    public function destroy()
    {
        abort(404);
    }
    
}
