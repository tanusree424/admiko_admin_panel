@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.admin_permissions.index") }}">Permissions</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Permissions
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.admin_permissions.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium admin-permissions-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.admin_permissions.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.admin_permissions.update", $data->id)}}@else{{route("admin.admin_permissions.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('admin_permissions_delete')
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
                            <label for="title">Title<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="title" autocomplete="off"
                                   name="title" required placeholder="Title"
                                   value="{{{ old('title', $data->title??'') }}}">
                            <div class="error-message @if ($errors->has('title')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="title_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="permission_slug">Permission slug<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="permission_slug" autocomplete="off"
                                   name="permission_slug" required placeholder="Permission slug"
                                   value="{{{ old('permission_slug', $data->permission_slug??'') }}}">
                            <div class="error-message @if ($errors->has('permission_slug')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="permission_slug_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-checkbox">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="custom_permission">Custom permission</label>
                        </div>
                        <div class="input-data">
                            <div class="checkbox-input form-switch">
                                <input type="hidden" name="custom_permission" value="0">
                                <input class="form-checkbox" type="checkbox" id="custom_permission" name="custom_permission" value="1"
                                       @if(old("custom_permission") || ((isset($data->custom_permission)&&$data->custom_permission==1)) || !isset($data->custom_permission)) checked @endif >
                                <label class="form-check-label" for="custom_permission"></label>
                            </div>
                            <div class="text-muted" id="custom_permission_help"></div>
                        </div>
                    </div>
                </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.admin_permissions.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection