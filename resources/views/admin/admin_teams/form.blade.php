@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.admin_teams.index") }}">Teams</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Teams
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.admin_teams.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium admin-teams-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.admin_teams.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.admin_teams.update", $data->id)}}@else{{route("admin.admin_teams.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('admin_teams_delete')
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
                            <label for="name">Name<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="name" autocomplete="off"
                                   name="name" required placeholder="Name"
                                   value="{{{ old('name', $data->name??'') }}}">
                            <div class="error-message @if ($errors->has('name')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="name_help"></div>
                        </div>
                    </div>
                </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.admin_teams.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection