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
namespace App\Http\Controllers\Admin\AdminUsers;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminUsers\AdminUsers;
use App\Requests\Admin\AdminUsers\AdminUsersRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Countries\Countries;
use Illuminate\Http\Request;
use App\Models\Admin\CompanyAddresses\CompanyAddresses;


class AdminUsersController extends Controller
{   
    public array $menu = ["item" =>"admin_users", "folder" =>"admin_settings", "subfolder" =>""];

    public function index()
    {
        if (Gate::none(['admin_users_access'])) {
            abort(403);
        }
		$menu = $this->menu;

        $admin_users_list_all = AdminUsers::startSearch(Request()->query("admin_users_search"))->orderBy("id")->get();
        return view("admin.admin_users.index")->with(compact('menu','admin_users_list_all'));
    }

    public function create()
    {
        if (Gate::none('admin_users_create')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = new AdminUsers();
        $countries = Countries::all();
        
        return view("admin.admin_users.form")->with(compact('menu','data', 'countries'));
    }

    public function store(AdminUsersRequest $request)
    {
        if (Gate::none('admin_users_create')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = AdminUsers::create($requestAll);
        
		$run->rolesMany()->sync(Request()->input("roles", []));
		$run->multiTenancyMany()->sync(Request()->input("multi_tenancy", []));

        return redirect(route("admin.admin_users.index"))->with("toast_success", trans('admin/misc.success_confirmation_created'));
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        if (Gate::none('admin_users_edit')) {
            abort(403);
        }
        $menu = $this->menu;
        $data = AdminUsers::findOrFail(request()->route()->admin_users_id);
        $countries = Countries::all();
        
        return view("admin.admin_users.form")->with(compact('menu', 'data', 'countries'));
    }

    public function update(AdminUsersRequest $request)
    {
        if (Gate::none('admin_users_edit')) {
            abort(403);
        }
        $requestAll = $request->all();
        $run = AdminUsers::findOrFail(request()->route()->admin_users_id);
		if($run->id > 1) {
			$run->rolesMany()->sync(Request()->input("roles", []));
		}
		$run->multiTenancyMany()->sync(Request()->input("multi_tenancy", []));
        $run->update($requestAll);
        return redirect(route("admin.admin_users.index"))->with("toast_success", trans('admin/misc.success_confirmation_updated'));
    }

    public function destroy()
    {
        if (Gate::none('admin_users_delete')) {
            abort(403);
        }
        if(in_array(1,Request()->delete_id)){
            return back()->with("toast_alert", trans("admin/misc.administrator_delete_error"));
        }
        AdminUsers::destroy(Request()->delete_id);
        return redirect(route("admin.admin_users.index"))->with("toast_success", trans('admin/misc.success_confirmation_deleted'));
    }
    
    public function country_auto_complete()
    {
        if(Request()->has('q')){
            $data = Countries::select("id","countryname")
            ->orWhere("countryname","LIKE","%".Request()->q."%")
            ->limit(50)->get()->sortBy("id");
        } else {
            $data = Countries::select("id","countryname")->limit(50)->get()->sortBy("id");
        }
        $return = $data->map(function ($item) {
            return ['id' => $item->id,'text' => $item->countryname." "];
        });
        return response()->json($return);
    }

    public function addCompanyAddress(Request $request)
    {
        $requestAll = $request->all();
        $request->validate([
            'billing_company_address' => 'required|string|max:255',
            'shipping_company_address' => 'required|string|max:255',
        ]);

        $userId = $requestAll['userId'] ?? null;
        $billing_company_address = $requestAll['billing_company_address'] ?? null;
        $shipping_company_address = $requestAll['shipping_company_address'] ?? null;


        if ($userId) {
            $companyAddress = CompanyAddresses::where('admin_user_lid', $userId)->first();
            if ($companyAddress) {
                $companyAddress->update([
                    'billing_address' => $billing_company_address,
                    'shipping_address' => $shipping_company_address,
                ]);
            } else {
                CompanyAddresses::create([
                    'admin_user_lid' => $userId,
                    'created_by' => $userId,
                    'billing_address' => $billing_company_address,
                    'shipping_address' => $shipping_company_address,
                ]);
            }
        }

        return response()->json([
            'id' => 1,
            'name' => $requestAll['billing_company_address'] ?? 'N/A',
            'address' => $requestAll['shipping_company_address'] ?? 'N/A',
            'city' => "Anytown"
        ]);
    }

    public function getCompanyAddress($userId)
    {
        $companyAddress = CompanyAddresses::where('admin_user_lid', $userId)->first();

        if ($companyAddress) {
            return response()->json([
                'billing_address' => $companyAddress->billing_address,
                'shipping_address' => $companyAddress->shipping_address,
            ]);
        }

        return response()->json([
            'billing_address' => '',
            'shipping_address' => '',
        ]);
    }
   
}
