@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.users.index") }}">Users</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Users
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.users.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium users-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.users.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.users.update", $data->id)}}@else{{route("admin.users.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('users_delete')
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
                            <label for="fullname">fullName</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="fullname" autocomplete="off"
                                   name="fullname"  placeholder="fullName"
                                   value="{{{ old('fullname', $data->fullname??'') }}}">
                            <div class="error-message @if ($errors->has('fullname')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="fullname_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="emailaddress">emailAddress<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="emailaddress" autocomplete="off"
                                   name="emailaddress" required placeholder="emailAddress"
                                   value="{{{ old('emailaddress', $data->emailaddress??'') }}}">
                            <div class="error-message @if ($errors->has('emailaddress')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="emailaddress_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="password">password</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="password" autocomplete="off"
                                   name="password"  placeholder="password"
                                   value="{{{ old('password', $data->password??'') }}}">
                            <div class="error-message @if ($errors->has('password')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="password_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="countryid">countryId</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="countryid" autocomplete="off"
                                   name="countryid"  placeholder="countryId"
                                   value="{{{ old('countryid', $data->countryid??'') }}}">
                            <div class="error-message @if ($errors->has('countryid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="countryid_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="role">role<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="role" autocomplete="off"
                                   name="role" required placeholder="role"
                                   value="{{{ old('role', $data->role??'') }}}">
                            <div class="error-message @if ($errors->has('role')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="role_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="status">status</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="status" autocomplete="off"
                                   name="status"  placeholder="status"
                                   value="{{{ old('status', $data->status??'') }}}">
                            <div class="error-message @if ($errors->has('status')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="status_help"></div>
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
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.users.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection