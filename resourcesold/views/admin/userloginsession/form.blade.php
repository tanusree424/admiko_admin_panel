@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.userloginsession.index") }}">UserLoginSession</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
UserLoginSession
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.userloginsession.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium userloginsession-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.userloginsession.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.userloginsession.update", $data->id)}}@else{{route("admin.userloginsession.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('userloginsession_delete')
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
                            <label for="sessionid">sessionId</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="sessionid" autocomplete="off"
                                   name="sessionid"  placeholder="sessionId"
                                   value="{{{ old('sessionid', $data->sessionid??'') }}}">
                            <div class="error-message @if ($errors->has('sessionid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="sessionid_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="userid">userId</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="userid" autocomplete="off"
                                   name="userid"  placeholder="userId"
                                   value="{{{ old('userid', $data->userid??'') }}}">
                            <div class="error-message @if ($errors->has('userid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="userid_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="logintime">loginTime</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="logintime" autocomplete="off"
                                   name="logintime"  placeholder="loginTime"
                                   value="{{{ old('logintime', $data->logintime??'') }}}">
                            <div class="error-message @if ($errors->has('logintime')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="logintime_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="logouttime">logoutTime</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="logouttime" autocomplete="off"
                                   name="logouttime"  placeholder="logoutTime"
                                   value="{{{ old('logouttime', $data->logouttime??'') }}}">
                            <div class="error-message @if ($errors->has('logouttime')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="logouttime_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="ipaddress">ipAddress</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="ipaddress" autocomplete="off"
                                   name="ipaddress"  placeholder="ipAddress"
                                   value="{{{ old('ipaddress', $data->ipaddress??'') }}}">
                            <div class="error-message @if ($errors->has('ipaddress')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="ipaddress_help"></div>
                        </div>
                    </div>
                </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.userloginsession.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection