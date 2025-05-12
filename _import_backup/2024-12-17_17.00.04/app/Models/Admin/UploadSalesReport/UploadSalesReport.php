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
namespace App\Models\Admin\UploadSalesReport;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminFileUploadTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadSalesReport extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait, AdminFileUploadTrait;
    public $table = 'upload_sales_report';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"sales_report_template_upload",
		"ak_sales_report_template_upload_delete",
		"created_by",
		"updated_by",
		"deleted_by",
		"created_by_team",
    ];
    
	public function fileInfo($key=false)
    {
        $file_info = [
			"sales_report_template_upload"=>[
				"disk"=>config("admin.settings.upload_disk"),
				"original"=>["folder"=>"/uploads/sales_reports/"]
			]
		];
        return ($key)?$file_info[$key]:$file_info;
    }
    public function setSalesReportTemplateUploadAttribute()
    {
        if (request()->hasFile('sales_report_template_upload')) {
            $this->attributes['sales_report_template_upload'] = $this->akFileUpload(request()->file("sales_report_template_upload"), $this->fileInfo("sales_report_template_upload"), $this->getOriginal('sales_report_template_upload'));
        }
    }
    public function getSalesReportTemplateUploadAttribute($value)
    {
        if ($value && $this->akFileExists($this->fileInfo("sales_report_template_upload")['disk'],$this->fileInfo("sales_report_template_upload")['original']["folder"],$value)) {
            return $this->akGetURLPath($this->fileInfo("sales_report_template_upload")['disk'],$this->fileInfo("sales_report_template_upload")['original']["folder"],$value);
        }
        return false;
    }
    public function setAkSalesReportTemplateUploadDeleteAttribute($delete)
    {
        if (!request()->hasFile('sales_report_template_upload') && $delete == 1) {
            $this->attributes['sales_report_template_upload'] = $this->akFileUpload('', $this->fileInfo("sales_report_template_upload"), $this->getOriginal('sales_report_template_upload'), 1);
        }
    }
}