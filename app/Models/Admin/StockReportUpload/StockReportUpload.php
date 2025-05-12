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
namespace App\Models\Admin\StockReportUpload;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminFileUploadTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockReportUpload extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait, AdminFileUploadTrait;
    public $table = 'stock_report_upload';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"stock_report_file",
		"ak_stock_report_file_delete",
		"created_by",
		"updated_by",
		"deleted_by",
		"created_by_team",
    ];
    
	public function fileInfo($key=false)
    {
        $file_info = [
			"stock_report_file"=>[
				"disk"=>config("admin.settings.upload_disk"),
				"original"=>["folder"=>"/uploads/stock_report/"]
			]
		];
        return ($key)?$file_info[$key]:$file_info;
    }
    public function setStockReportFileAttribute()
    {
        if (request()->hasFile('stock_report_file')) {
            $this->attributes['stock_report_file'] = $this->akFileUpload(request()->file("stock_report_file"), $this->fileInfo("stock_report_file"), $this->getOriginal('stock_report_file'));
        }
    }
    public function getStockReportFileAttribute($value)
    {
        if ($value && $this->akFileExists($this->fileInfo("stock_report_file")['disk'],$this->fileInfo("stock_report_file")['original']["folder"],$value)) {
            return $this->akGetURLPath($this->fileInfo("stock_report_file")['disk'],$this->fileInfo("stock_report_file")['original']["folder"],$value);
        }
        return false;
    }
    public function setAkStockReportFileDeleteAttribute($delete)
    {
        if (!request()->hasFile('stock_report_file') && $delete == 1) {
            $this->attributes['stock_report_file'] = $this->akFileUpload('', $this->fileInfo("stock_report_file"), $this->getOriginal('stock_report_file'), 1);
        }
    }
}