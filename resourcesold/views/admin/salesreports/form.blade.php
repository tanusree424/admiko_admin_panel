@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.salesreports.index") }}">SalesReports</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
SalesReports
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.salesreports.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium salesreports-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.salesreports.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.salesreports.update", $data->id)}}@else{{route("admin.salesreports.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('salesreports_delete')
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
                <div class="row-100 el-box-select">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="product_1">product</label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="product_1" name="product_1" >
                                <option value="">{{trans("admin/form.select")}}</option>
								@foreach($data->product1ListAll() as $row)
                                    <option value="{{ $row->id }}" {{ (old('product_1') ? old('product_1') : $data->product_1 ?? '') == $row->id ? 'selected' : '' }}>{{ $row->productname }} </option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('product_1')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="product_1_help"></div>
                        </div>
                    </div>
                </div>

                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="invoicenumber">invoiceNumber<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="invoicenumber" autocomplete="off"
                                   name="invoicenumber" required placeholder="invoiceNumber"
                                   value="{{{ old('invoicenumber', $data->invoicenumber??'') }}}">
                            <div class="error-message @if ($errors->has('invoicenumber')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="invoicenumber_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="invoicedate">invoiceDate</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="invoicedate" autocomplete="off"
                                   name="invoicedate"  placeholder="invoiceDate"
                                   value="{{{ old('invoicedate', $data->invoicedate??'') }}}">
                            <div class="error-message @if ($errors->has('invoicedate')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="invoicedate_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="reportmonth">reportMonth</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="reportmonth" autocomplete="off"
                                   name="reportmonth"  placeholder="reportMonth"
                                   value="{{{ old('reportmonth', $data->reportmonth??'') }}}">
                            <div class="error-message @if ($errors->has('reportmonth')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="reportmonth_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="week">week</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="week" autocomplete="off"
                                   name="week"  placeholder="week"
                                   value="{{{ old('week', $data->week??'') }}}">
                            <div class="error-message @if ($errors->has('week')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="week_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="customername">customerName</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="customername" autocomplete="off"
                                   name="customername"  placeholder="customerName"
                                   value="{{{ old('customername', $data->customername??'') }}}">
                            <div class="error-message @if ($errors->has('customername')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="customername_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="location">location</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="location" autocomplete="off"
                                   name="location"  placeholder="location"
                                   value="{{{ old('location', $data->location??'') }}}">
                            <div class="error-message @if ($errors->has('location')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="location_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="channel">channel</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="channel" autocomplete="off"
                                   name="channel"  placeholder="channel"
                                   value="{{{ old('channel', $data->channel??'') }}}">
                            <div class="error-message @if ($errors->has('channel')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="channel_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="qty">qty</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="qty" autocomplete="off"
                                   name="qty"  placeholder="qty"
                                   value="{{{ old('qty', $data->qty??'') }}}">
                            <div class="error-message @if ($errors->has('qty')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="qty_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="originalunitprice">originalUnitPrice</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="originalunitprice" autocomplete="off"
                                   name="originalunitprice"  placeholder="originalUnitPrice"
                                   value="{{{ old('originalunitprice', $data->originalunitprice??'') }}}">
                            <div class="error-message @if ($errors->has('originalunitprice')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="originalunitprice_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="grossamount">grossAmount</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="grossamount" autocomplete="off"
                                   name="grossamount"  placeholder="grossAmount"
                                   value="{{{ old('grossamount', $data->grossamount??'') }}}">
                            <div class="error-message @if ($errors->has('grossamount')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="grossamount_help"></div>
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
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.salesreports.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection