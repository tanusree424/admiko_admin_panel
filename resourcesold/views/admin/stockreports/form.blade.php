@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.stockreports.index") }}">StockReports</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
StockReports
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.stockreports.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium stockreports-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.stockreports.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.stockreports.update", $data->id)}}@else{{route("admin.stockreports.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('stockreports_delete')
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
                            <label for="my_id">id</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="my_id" autocomplete="off"
                                   name="my_id"  placeholder="id"
                                   value="{{{ old('my_id', $data->my_id??'') }}}">
                            <div class="error-message @if ($errors->has('my_id')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="my_id_help"></div>
                        </div>
                    </div>
                </div>
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
                            <label for="stockinhand">stockInHand<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="stockinhand" autocomplete="off"
                                   name="stockinhand" required placeholder="stockInHand"
                                   value="{{{ old('stockinhand', $data->stockinhand??'') }}}">
                            <div class="error-message @if ($errors->has('stockinhand')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="stockinhand_help"></div>
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
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.stockreports.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection