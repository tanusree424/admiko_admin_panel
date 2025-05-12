@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.admin_roles.index") }}">Roles</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Roles
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.admin_roles.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium admin-roles-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.admin_roles.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.admin_roles.update", $data->id)}}@else{{route("admin.admin_roles.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('admin_roles_delete')
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
                <div class="row-100 el-box-multi-select">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="users">Users</label>
                        </div>
                        <div class="input-data">
                            <select class="form-select js-ak-select2-many" id="users" 
                                data-placeholder="{{trans("admin/form.select")}}" multiple="multiple" data-width="100%"  data-allow-clear="true"
                                name="users[]" >
                                @foreach($data->usersListAll() as $row)
                                    @php $selected = ""; @endphp
                                    @if(in_array($row->id, old('users', [])))
                                        @php $selected = "selected"; @endphp
                                    @elseIf(isset($data->id) && $data->usersMany->contains($row->id))
                                        @php $selected = "selected"; @endphp
                                    @endIf
                                    <option value="{{ $row->id }}" {{$selected}}>{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('users')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="users_help"></div>
                        </div>
                    </div>
                </div>

                <div class="row-100 el-box-permissions js-ak-permissions">
                @if(isset($data) && $data->id == 1)
                <div class="input-container">
                    <div class="input-label">
                        <label for="permissions">Permissions</label>
                    </div>
                    <div class="input-data">
                        {{trans("admin/misc.admin_role_has_full_access")}}
                    </div>
                </div>
                @else
                <div class="input-container">
                    <div class="input-label">
                        <label>Permissions</label>
                    </div>
                    <div class="input-data">
                        <div>
                            <div>
                                <div class="form-icon js-ak-toggle-permission-group-select-all" style="cursor: pointer">
                                    @includeIf("admin/admin_layout/partials/misc/icons/select_all")
                                </div>
                            </div>
                            @foreach(collect($data->permissionsListAll())->groupBy('title') as $title =>$items)
                            <div class="input-container js-ak-permission-group" style="padding-bottom: 6px">
                                <div class="input-label">
                                    <label class="js-ak-permission-title" style="cursor: pointer">{{$title}}</label>
                                </div>
                                <div class="">
                                    @foreach($items as $row)
                                        @php $checked = ""; @endphp
                                        @if(in_array($row->id, old('permissions', [])))
                                            @php $checked = "checked"; @endphp
                                        @elseIf(isset($data->id) && $data->permissionsMany->contains($row->id))
                                            @php $checked = "checked"; @endphp
                                        @endIf
                                        <label class="checkbox-input">
                                            <input type="checkbox" class="form-checkbox" name="permissions[]" id="permissions{{ $row->id }}" value="{{ $row->id }}" {{$checked}} >
                                            @if(Str::endsWith($row->permission_slug, '_access'))
                                                {{trans("admin/form.access")}}
                                            @elseif(Str::endsWith($row->permission_slug, '_create'))
                                                {{trans("admin/form.create")}}
                                            @elseif(Str::endsWith($row->permission_slug, '_edit'))
                                                {{trans("admin/form.edit")}}
                                            @elseif(Str::endsWith($row->permission_slug, '_delete'))
                                                {{trans("admin/form.delete")}}
                                            @elseif(Str::endsWith($row->permission_slug, '_show'))
                                                {{trans("admin/form.show")}}
                                            @else
                                                {{$row->permission_slug}}
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                            <div class="text-muted" id="permissions_help"></div>
                        </div>
                    </div>
                </div>
                @endif
                </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.admin_roles.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@push('footer_stack_bottom')
<script>
    $('.js-ak-permissions').on('click', '.js-ak-permission-title', function (event) {
        event.preventDefault();
        let parent = $(this).closest(".js-ak-permission-group")
        parent.find("input[type=checkbox]").prop("checked", !parent.find("input[type=checkbox]").prop("checked"));
    }).on('click', '.js-ak-toggle-permission-group-select-all', function (event) {
        event.preventDefault();
        let parent = $(this).closest(".js-ak-permissions")
        parent.find("input[type=checkbox]").prop("checked", !parent.find("input[type=checkbox]").prop("checked"));
    })
</script>
@endpush
@endsection