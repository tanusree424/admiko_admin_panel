@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.purchaseorderslogs.index") }}">PurchaseOrdersLogs</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
PurchaseOrdersLogs
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.purchaseorderslogs.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium purchaseorderslogs-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.purchaseorderslogs.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.purchaseorderslogs.update", $data->id)}}@else{{route("admin.purchaseorderslogs.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('purchaseorderslogs_delete')
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
                            <label for="poid">poId</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="poid" autocomplete="off"
                                   name="poid"  placeholder="poId"
                                   value="{{{ old('poid', $data->poid??'') }}}">
                            <div class="error-message @if ($errors->has('poid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="poid_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="comment">comment<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="comment" autocomplete="off"
                                   name="comment" required placeholder="comment"
                                   value="{{{ old('comment', $data->comment??'') }}}">
                            <div class="error-message @if ($errors->has('comment')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="comment_help"></div>
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
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.purchaseorderslogs.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection