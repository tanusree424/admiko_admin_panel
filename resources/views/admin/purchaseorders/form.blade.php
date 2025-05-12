@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.purchaseorders.index") }}">PurchaseOrders</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
PurchaseOrders
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.purchaseorders.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium purchaseorders-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.purchaseorders.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.purchaseorders.update", $data->id)}}@else{{route("admin.purchaseorders.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('purchaseorders_delete')
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
                            <label for="distributorid">distributorId</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="distributorid" autocomplete="off"
                                   name="distributorid"  placeholder="distributorId"
                                   value="{{{ old('distributorid', $data->distributorid??'') }}}">
                            <div class="error-message @if ($errors->has('distributorid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="distributorid_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="productid">productId</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="productid" autocomplete="off"
                                   name="productid"  placeholder="productId"
                                   value="{{{ old('productid', $data->productid??'') }}}">
                            <div class="error-message @if ($errors->has('productid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="productid_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="ordertime">orderTime</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="ordertime" autocomplete="off"
                                   name="ordertime"  placeholder="orderTime"
                                   value="{{{ old('ordertime', $data->ordertime??'') }}}">
                            <div class="error-message @if ($errors->has('ordertime')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="ordertime_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="orderprice">orderPrice</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="orderprice" autocomplete="off"
                                   name="orderprice"  placeholder="orderPrice"
                                   value="{{{ old('orderprice', $data->orderprice??'') }}}">
                            <div class="error-message @if ($errors->has('orderprice')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="orderprice_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="orderqty">orderQty<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="orderqty" autocomplete="off"
                                   name="orderqty" required placeholder="orderQty"
                                   value="{{{ old('orderqty', $data->orderqty??'') }}}">
                            <div class="error-message @if ($errors->has('orderqty')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="orderqty_help"></div>
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

        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.purchaseorders.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection