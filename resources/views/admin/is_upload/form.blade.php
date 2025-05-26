@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{route("admin.home")}}">IS Upload</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
IS Upload
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="form-container content-width-medium is-upload-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.is_upload.delete")}}">
    <form method="POST" action="{{route("admin.is_upload.store")}}" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @csrf
        </div>
        <div class="form-header">
            <h3></h3>
        </div>
        @includeIf("admin.admin_layout.partials.form.errors")
        <div class="form-content">

                <div class="row-100 el-box-file">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="select_is_template">Select IS Template<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            @if ($data->select_is_template)
                                <div>
                                    <a href="{{ $data->select_is_template }}" target="_blank" class="js-ak-select_is_template-available">
                                        {{$data->select_is_template}}
                                    </a>
                                </div>

                            @elseif(isset($data->select_po_template) && $data->getRawOriginal("select_is_template"))
                                <div class="alert-info-container">
                                    <div>'{{$data->getRawOriginal("select_is_template")}}' {{trans('admin/form.file_location_error')}}</div>
                                </div>
                            @endif
                            <input type="file" class="form-file js-ak-file-upload" data-id="select_is_template" accept=".xls,.xlsx" data-file-type=".xls,.xlsx" data-file-max-size="5" name="select_is_template" @if(!isset($data) || !$data->select_is_template) required @endIf>
                            <input type="hidden" name="ak_select_is_template_current" value="{{$data->getRawOriginal("select_is_template")??''}}">
                            <div class="error-message @if ($errors->has('select_is_template')) show @endif" data-required="{{trans('admin/form.required_file')}}" data-size="{{trans('admin/form.required_size')}}" data-type="{{trans('admin/form.required_type')}}" data-size-type="{{trans('admin/form.invalid_size_or_type')}}">
                                @if ($errors->has('select_is_template')){{ $errors->first('select_is_template') }}@endif
                            </div>
                            <div class="text-muted" id="select_is_template_help">{{trans("admin/form.file_size_limit")}}5 MB. {{trans("admin/form.file_extension_limit")}}.xls,.xlsx. </div>
                        </div>
                    </div>
                </div>
        </div>
       <input type="submit" class="button primary-button submit-button" name="submit" value="Upload">
    </form>
    <form method="POST" action="{{ route('admin.is_upload.export') }}" style="margin-top:25px;" novalidate>
        @csrf
        <button type="submit" class="button primary-button submit-button"> <i class="fa-regular fa-download"></i> Download</button>
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection
