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
namespace App\Http\Controllers\Admin\Userloginsession;
use App\Http\Controllers\Controller;
use App\Models\Admin\Userloginsession\Userloginsession;
use App\Requests\Admin\Userloginsession\UserloginsessionRequest;
use Illuminate\Support\Facades\Gate;
class UserloginsessionController extends Controller
{   
    public array $menu = ["item" =>"userloginsession", "folder" =>"", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['userloginsession_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $userloginsession_list_all = Userloginsession::startSearch(Request()->query("userloginsession_search"))->orderByDesc("id")->get();
        return view("admin.userloginsession.index")->with(compact('menu','userloginsession_list_all'))->fragmentIf(Request()->ajax_call==1, "userloginsession_fragment");
    }

    public function create()
    {
        if (Gate::none('userloginsession_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new Userloginsession();
        
        return view("admin.userloginsession.form")->with(compact('menu','data'));
    }

    public function store(UserloginsessionRequest $request)
    {
        if (Gate::none('userloginsession_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Userloginsession::create($requestAll);
        

        return redirect(route("admin.userloginsession.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('userloginsession_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = Userloginsession::findOrFail(request()->route()->userloginsession_id);;
        
        return view("admin.userloginsession.form")->with(compact('menu', 'data'));
    }

    public function update(UserloginsessionRequest $request)
    {
        if (Gate::none('userloginsession_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = Userloginsession::findOrFail(request()->route()->userloginsession_id);
        $run->update($requestAll);
        return redirect(route("admin.userloginsession.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('userloginsession_delete')) {
            if(Request()->has("ajax_call") && Request()->ajax_call == 1){
                return response()->json(array(
                    'success' => false,
                    'message'   => trans('admin/misc.forbidden_access_error')
                ));
            } else {
                abort(403);
            }
        }
        Userloginsession::destroy(Request()->delete_id);
        if(Request()->has("ajax_call") && Request()->ajax_call == 1){
            return response()->json(array(
                'success' => true,
                'message'   => trans('admin/misc.success_confirmation_deleted')
            ));
        } else {
            return redirect(route("admin.userloginsession.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
        }
    }
    
}
