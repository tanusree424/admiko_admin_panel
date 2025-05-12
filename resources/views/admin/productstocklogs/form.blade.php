@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.productstocklogs.index") }}">ProductStockLogs</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
ProductStockLogs
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.productstocklogs.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium productstocklogs-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.productstocklogs.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.productstocklogs.update", $data->id)}}@else{{route("admin.productstocklogs.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('productstocklogs_delete')
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
                            <label for="logid">logId</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="logid" autocomplete="off"
                                   name="logid"  placeholder="logId"
                                   value="{{{ old('logid', $data->logid??'') }}}">
                            <div class="error-message @if ($errors->has('logid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="logid_help"></div>
                        </div>
                    </div>
                </div>
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
                            <label for="comment">comment</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="comment" autocomplete="off"
                                   name="comment"  placeholder="comment"
                                   value="{{{ old('comment', $data->comment??'') }}}">
                            <div class="error-message @if ($errors->has('comment')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="comment_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="updatedby">updatedBy</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="updatedby" autocomplete="off"
                                   name="updatedby"  placeholder="updatedBy"
                                   value="{{{ old('updatedby', $data->updatedby??'') }}}">
                            <div class="error-message @if ($errors->has('updatedby')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="updatedby_help"></div>
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
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.productstocklogs.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection