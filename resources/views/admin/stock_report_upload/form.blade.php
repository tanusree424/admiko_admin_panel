@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{route("admin.home")}}">Stock Report Upload</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Stock Report Upload
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="form-container content-width-medium stock-report-upload-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.stock_report_upload.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.stock_report_upload.update", $data->id)}}@else{{route("admin.stock_report_upload.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
        </div>
        @includeIf("admin.admin_layout.partials.form.errors")
        <div class="form-content">

                <div class="row-100 el-box-file">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="stock_report_file">Stock Report<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            @if ($data->stock_report_file)
                                <div>
                                    <a href="{{ $data->stock_report_file }}" target="_blank" class="js-ak-stock_report_file-available">
                                        {{$data->stock_report_file}}
                                    </a>
                                </div>

                            @elseif(isset($data->stock_report_file) && $data->getRawOriginal("stock_report_file"))
                                <div class="alert-info-container">
                                    <div>'{{$data->getRawOriginal("stock_report_file")}}' {{trans('admin/form.file_location_error')}}</div>
                                </div>
                            @endif
                            <input type="file" class="form-file js-ak-file-upload" data-id="stock_report_file" accept=".xls,.xlsx" data-file-type=".xls,.xlsx" data-file-max-size="10" name="stock_report_file" @if(!isset($data) || !$data->stock_report_file) required @endIf>
                            <input type="hidden" name="ak_stock_report_file_current" value="{{$data->getRawOriginal("stock_report_file")??''}}">
                            <div class="error-message @if ($errors->has('stock_report_file')) show @endif" data-required="{{trans('admin/form.required_file')}}" data-size="{{trans('admin/form.required_size')}}" data-type="{{trans('admin/form.required_type')}}" data-size-type="{{trans('admin/form.invalid_size_or_type')}}">
                                @if ($errors->has('stock_report_file')){{ $errors->first('stock_report_file') }}@endif
                            </div>
                            <div class="text-muted" id="stock_report_file_help">{{trans("admin/form.file_size_limit")}}10 MB. {{trans("admin/form.file_extension_limit")}}.xls,.xslx. </div>
                        </div>
                    </div>
                </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.home")])
    </form>
    <form method="POST" action="{{ route('admin.export_stock_template.export') }}" style="margin-top:25px;" novalidate>
        @csrf
        <button type="submit" class="button primary-button submit-button"> <i class="fa-regular fa-download"></i> Download</button>
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection
