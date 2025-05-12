@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.product_stock_a.index") }}">Products Stock</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Products Stock
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.product_stock_a.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium product-stock-a-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.product_stock_a.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.product_stock_a.update", $data->id)}}@else{{route("admin.product_stock_a.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('product_stock_a_delete')
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
                            <label for="product_1">Product<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <select class="form-select  js-ak-select2" id="product_1"
                                    data-placeholder="{{trans("admin/form.select")}}" data-width="100%"  data-allow-clear="false" data-search-url="{{route("admin.product_stock_a.product_1_auto_complete")}}"
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


                <div class="row-100 el-box-number">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="stock">stock</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input js-ak-limit-poz-neg-numbers"
                                   id="stock" name="stock"  placeholder="stock" autocomplete="off"
                                   value="{{{ old('stock', $data->stock??'') }}}">
                            <div class="error-message @if ($errors->has('stock')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="stock_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="partcode">partcode<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="partcode" autocomplete="off"
                                   name="partcode" required placeholder="partcode"
                                   value="{{{ old('partcode', $data->partcode??'') }}}">
                            <div class="error-message @if ($errors->has('partcode')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="partcode_help"></div>
                        </div>
                    </div>
                </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.product_stock_a.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection
