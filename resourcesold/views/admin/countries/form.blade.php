@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.countries.index") }}">Countries</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Countries
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.countries.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium countries-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.countries.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.countries.update", $data->id)}}@else{{route("admin.countries.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('countries_delete')
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
                            <label for="countryname">countryName<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="countryname" autocomplete="off"
                                   name="countryname" required placeholder="countryName"
                                   value="{{{ old('countryname', $data->countryname??'') }}}">
                            <div class="error-message @if ($errors->has('countryname')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="countryname_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-select-custom">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="status">status</label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="status" name="status" >
                                <option value="">{{trans("admin/form.select")}}</option>
								@foreach($data::STATUS_CONS as $value => $label)
                                    <option value="{{ $value }}" {{ (old('status') ? old('status') : $data->status ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('status')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="status_help"></div>
                        </div>
                    </div>
                </div>

                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="createdby">createdBy</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="createdby" autocomplete="off"
                                   name="createdby"  placeholder="createdBy"
                                   value="{{{ old('createdby', $data->createdby??'') }}}">
                            <div class="error-message @if ($errors->has('createdby')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="createdby_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="createdtime">createdTime</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="createdtime" autocomplete="off"
                                   name="createdtime"  placeholder="createdTime"
                                   value="{{{ old('createdtime', $data->createdtime??'') }}}">
                            <div class="error-message @if ($errors->has('createdtime')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="createdtime_help"></div>
                        </div>
                    </div>
                </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.countries.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection