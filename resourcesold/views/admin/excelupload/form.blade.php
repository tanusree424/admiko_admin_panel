@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.excelupload.index") }}">ExcelUpload</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
ExcelUpload
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.excelupload.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium excelupload-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.excelupload.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.excelupload.update", $data->id)}}@else{{route("admin.excelupload.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('excelupload_delete')
                    @if(isset($data->id))
                    <a href="#" data-id="{{$data->id}}" class="delete-link js-ak-delete-link" draggable="false">
                        @includeIf("admin/admin_layout/partials/misc/icons/delete_icon")
                    </a>
                    @endIf
                @endcan
            </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.errors")
        <div class="form-content">
            
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="excelid">excelId</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="excelid" autocomplete="off"
                                   name="excelid"  placeholder="excelId"
                                   value="{{{ old('excelid', $data->excelid??'') }}}">
                            <div class="error-message @if ($errors->has('excelid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="excelid_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="exceltype">excelType<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="exceltype" autocomplete="off"
                                   name="exceltype" required placeholder="excelType"
                                   value="{{{ old('exceltype', $data->exceltype??'') }}}">
                            <div class="error-message @if ($errors->has('exceltype')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="exceltype_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="excelpath">excelPath<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="excelpath" autocomplete="off"
                                   name="excelpath" required placeholder="excelPath"
                                   value="{{{ old('excelpath', $data->excelpath??'') }}}">
                            <div class="error-message @if ($errors->has('excelpath')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="excelpath_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="uploadedby">uploadedBy</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="uploadedby" autocomplete="off"
                                   name="uploadedby"  placeholder="uploadedBy"
                                   value="{{{ old('uploadedby', $data->uploadedby??'') }}}">
                            <div class="error-message @if ($errors->has('uploadedby')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="uploadedby_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="uploadedtime">uploadedTime</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="uploadedtime" autocomplete="off"
                                   name="uploadedtime"  placeholder="uploadedTime"
                                   value="{{{ old('uploadedtime', $data->uploadedtime??'') }}}">
                            <div class="error-message @if ($errors->has('uploadedtime')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="uploadedtime_help"></div>
                        </div>
                    </div>
                </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.excelupload.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection