@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.productstock.index") }}">ProductStock</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
ProductStock
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.productstock.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium productstock-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.productstock.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.productstock.update", $data->id)}}@else{{route("admin.productstock.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('productstock_delete')
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
                            <label for="stockid">stockId</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="stockid" autocomplete="off"
                                   name="stockid"  placeholder="stockId"
                                   value="{{{ old('stockid', $data->stockid??'') }}}">
                            <div class="error-message @if ($errors->has('stockid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="stockid_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-select-search">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="country">country</label>
                        </div>
                        <div class="input-data">
                            <select class="form-select  js-ak-select2" id="country"
                                    data-placeholder="{{trans("admin/form.select")}}" data-width="100%"  data-allow-clear="true" data-search-url="{{route("admin.productstock.country_auto_complete")}}"
                                    name="country" >
                                <option value="">{{trans("admin/form.select")}}</option>
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
                            <label for="quantity">quantity<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="quantity" autocomplete="off"
                                   name="quantity" required placeholder="quantity"
                                   value="{{{ old('quantity', $data->quantity??'') }}}">
                            <div class="error-message @if ($errors->has('quantity')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="quantity_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-select-search">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="product_1">Product<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <select class="form-select  js-ak-select2" id="product_1"
                                    data-placeholder="{{trans("admin/form.select")}}" data-width="100%"  data-allow-clear="false" data-search-url="{{route("admin.productstock.product_1_auto_complete")}}"
                                    name="product_1" required>
                                @if($data->product1ToValue)
                                    <option value="{{ $data->product1ToValue->id }}" {{ (old('product_1') ? old('product_1') : $data->product_1 ?? '') == $data->product1ToValue->id ? 'selected' : '' }}>{{$data->product1ToValue->productname}} </option>
                                @endif
                            </select>
                            <div class="error-message @if ($errors->has('product_1')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="product_1_help"></div>
                        </div>
                    </div>
                </div>


                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="price">price</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="price" autocomplete="off"
                                   name="price"  placeholder="price"
                                   value="{{{ old('price', $data->price??'') }}}">
                            <div class="error-message @if ($errors->has('price')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="price_help"></div>
                        </div>
                    </div>
                </div>
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
                            <label for="updatedtime">updatedTime</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="updatedtime" autocomplete="off"
                                   name="updatedtime"  placeholder="updatedTime"
                                   value="{{{ old('updatedtime', $data->updatedtime??'') }}}">
                            <div class="error-message @if ($errors->has('updatedtime')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="updatedtime_help"></div>
                        </div>
                    </div>
                </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.productstock.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection