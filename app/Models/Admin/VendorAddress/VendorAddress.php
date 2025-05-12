<?php
namespace App\Models\Admin\VendorAddress;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminHelperTrait;
use App\Models\Admin\AdminRoles\AdminRoles;
use App\Models\Admin\AdminTeams\AdminTeams;
use App\Models\Admin\Orders\Orders;

class VendorAddress extends Model
{
    use AdminHelperTrait;
    public $table = 'vendor_address';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'address',
        'created_by'
    ];

    public static function findBAddressByUserId($adminUserLid)
    {
        return self::where('created_by', $adminUserLid)->first();
    }

    public static function findAll()
    {
        return self::all()->first();
    }
   
}