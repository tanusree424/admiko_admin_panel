@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.location.index") }}">Loaction</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Location
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.location.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium location-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.brands.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.location.update", $data->id)}}@else{{route("admin.location.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('brands_delete')
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
                            <label for="locationName">LocationName<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="location_name" autocomplete="off"
                                   name="location_name" required placeholder="location Name"
                                   value="{{{ old('location_name', $location->location_name??'') }}}">
                            <div class="error-message @if ($errors->has('location_name')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="brandname_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-select-custom">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="status">Country</label>
                        </div>
                       <div class="input-data">
    <select class="form-select" id="country_id" name="country_id">
        <option value="">{{ trans("admin/form.select") }}</option>
        @foreach($countries as $country)
            <option value="{{ $country->id }}" {{ (old('country_id', $location->country_id ?? '') == $country->id) ? 'selected' : '' }}>
                {{ $country->countryname }}
            </option>
        @endforeach
    </select>
    <div class="error-message @if ($errors->has('country_id')) show @endif">{{ trans('admin/form.required_text') }}</div>
    <div class="text-muted" id="country_id_help"></div>
</div>

                    </div>
                </div>

                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="region">Region</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="region" autocomplete="off"
                                   name="region"  placeholder="Region"
                                   value="{{{ old('region', $location->region??'') }}}">
                            <div class="error-message @if ($errors->has('region')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="region_help"></div>
                        </div>
                    </div>
                </div>

        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.location.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection
