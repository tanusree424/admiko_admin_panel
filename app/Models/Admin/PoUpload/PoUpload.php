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
namespace App\Models\Admin\PoUpload;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminService\Traits\AdminAuditableTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminFileUploadTrait;
use App\Http\Controllers\Admin\AdminService\Traits\AdminMultiTenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoUpload extends Model
{
    use SoftDeletes, AdminAuditableTrait, AdminMultiTenantTrait, AdminFileUploadTrait;
    public $table = 'po_upload';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"select_po_template",
		"ak_select_po_template_delete",
		"created_by",
		"updated_by",
		"deleted_by",
		"created_by_team",
    ];
    
	public function fileInfo($key=false)
    {
        $file_info = [
			"select_po_template"=>[
				"disk"=>config("admin.settings.upload_disk"),
				"original"=>["folder"=>"/uploads/orders/"]
			]
		];
        return ($key)?$file_info[$key]:$file_info;
    }
    public function setSelectPoTemplateAttribute()
    {
        if (request()->hasFile('select_po_template')) {
            $this->attributes['select_po_template'] = $this->akFileUpload(request()->file("select_po_template"), $this->fileInfo("select_po_template"), $this->getOriginal('select_po_template'));
        }
    }
    public function getSelectPoTemplateAttribute($value)
    {
        if ($value && $this->akFileExists($this->fileInfo("select_po_template")['disk'],$this->fileInfo("select_po_template")['original']["folder"],$value)) {
            return $this->akGetURLPath($this->fileInfo("select_po_template")['disk'],$this->fileInfo("select_po_template")['original']["folder"],$value);
        }
        return false;
    }
    public function setAkSelectPoTemplateDeleteAttribute($delete)
    {
        if (!request()->hasFile('select_po_template') && $delete == 1) {
            $this->attributes['select_po_template'] = $this->akFileUpload('', $this->fileInfo("select_po_template"), $this->getOriginal('select_po_template'), 1);
        }
    }
}