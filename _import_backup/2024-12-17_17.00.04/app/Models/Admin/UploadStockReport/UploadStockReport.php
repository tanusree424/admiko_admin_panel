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
namespace App\Models\Admin\UploadStockReport;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminFileUploadTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadStockReport extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait, AdminFileUploadTrait;
    public $table = 'upload_stock_report';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"select_stock_report_template",
		"ak_select_stock_report_template_delete",
		"created_by",
		"updated_by",
		"deleted_by",
		"created_by_team",
    ];
    
	public function fileInfo($key=false)
    {
        $file_info = [
			"select_stock_report_template"=>[
				"disk"=>config("admin.settings.upload_disk"),
				"original"=>["folder"=>"/uploads/stock_reports/"]
			]
		];
        return ($key)?$file_info[$key]:$file_info;
    }
    public function setSelectStockReportTemplateAttribute()
    {
        if (request()->hasFile('select_stock_report_template')) {
            $this->attributes['select_stock_report_template'] = $this->akFileUpload(request()->file("select_stock_report_template"), $this->fileInfo("select_stock_report_template"), $this->getOriginal('select_stock_report_template'));
        }
    }
    public function getSelectStockReportTemplateAttribute($value)
    {
        if ($value && $this->akFileExists($this->fileInfo("select_stock_report_template")['disk'],$this->fileInfo("select_stock_report_template")['original']["folder"],$value)) {
            return $this->akGetURLPath($this->fileInfo("select_stock_report_template")['disk'],$this->fileInfo("select_stock_report_template")['original']["folder"],$value);
        }
        return false;
    }
    public function setAkSelectStockReportTemplateDeleteAttribute($delete)
    {
        if (!request()->hasFile('select_stock_report_template') && $delete == 1) {
            $this->attributes['select_stock_report_template'] = $this->akFileUpload('', $this->fileInfo("select_stock_report_template"), $this->getOriginal('select_stock_report_template'), 1);
        }
    }
}