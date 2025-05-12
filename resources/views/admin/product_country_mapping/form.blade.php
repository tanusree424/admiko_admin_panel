@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.product_country_mapping.index") }}">Product Country Mapping</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Product Country Mapping
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.product_country_mapping.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium product-country-mapping-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.product_country_mapping.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.product_country_mapping.update", $data->id)}}@else{{route("admin.product_country_mapping.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('product_country_mapping_delete')
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
            
                <div class="row-100 el-box-select-search">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="products">Products<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <select class="form-select  js-ak-select2" id="products"
                                    data-placeholder="{{trans("admin/form.select")}}" data-width="100%"  data-allow-clear="false" data-search-url="{{route("admin.product_country_mapping.products_auto_complete")}}"
                                    name="products" required>
                                @if($data->productsToValue)
                                    <option value="{{ $data->productsToValue->id }}" {{ (old('products') ? old('products') : $data->products ?? '') == $data->productsToValue->id ? 'selected' : '' }}>{{$data->productsToValue->productname}} </option>
                                @endif
                            </select>
                            <div class="error-message @if ($errors->has('products')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="products_help"></div>
                        </div>
                    </div>
                </div>


                <div class="row-100 el-box-select-search">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="country">Country<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <select class="form-select  js-ak-select2" id="country"
                                    data-placeholder="{{trans("admin/form.select")}}" data-width="100%"  data-allow-clear="false" data-search-url="{{route("admin.product_country_mapping.country_auto_complete")}}"
                                    name="country" required>
                                @if($data->countryToValue)
                                    <option value="{{ $data->countryToValue->id }}" {{ (old('country') ? old('country') : $data->country ?? '') == $data->countryToValue->id ? 'selected' : '' }}>{{$data->countryToValue->countryname}} </option>
                                @endif
                            </select>
                            <div class="error-message @if ($errors->has('country')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="country_help"></div>
                        </div>
                    </div>
                </div>


                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="price">Price<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="price" autocomplete="off"
                                   name="price" required placeholder="Price"
                                   value="{{{ old('price', $data->price??'') }}}">
                            <div class="error-message @if ($errors->has('price')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="price_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-select-custom">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="status">Status<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="status" name="status" required>
                                @foreach($data::STATUS_CONS as $value => $label)
                                    <option value="{{ $value }}" {{ (old('status') ? old('status') : $data->status ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('status')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="status_help"></div>
                        </div>
                    </div>
                </div>

        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.product_country_mapping.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection