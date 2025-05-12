<?php
namespace App\Models\Admin\CompanyAddresses;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminHelperTrait;
use App\Models\Admin\AdminRoles\AdminRoles;
use App\Models\Admin\AdminTeams\AdminTeams;
use App\Models\Admin\Orders\Orders;

class CompanyAddresses extends Model
{
    use AdminHelperTrait;
    public $table = 'company_addresses';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'billing_address',
        'shipping_address',
        'created_by',
        'updated_by',
        'enabled',
        'admin_user_lid',
    ];

    public static function getAddressByAdminUserLid($adminUserLid)
    {
        return self::where('admin_user_lid', $adminUserLid)->first();
    }

}