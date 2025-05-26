@extends("admin.admin_layout.default")

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route("admin.users.index") }}">Users</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{ trans('admin/form.breadcrumbs_edit') }}</li>
    @else
        <li class="breadcrumb-item active">{{ trans('admin/form.breadcrumbs_add') }}</li>
    @endif
@endsection

@section('page-title') Users @endsection
@section('page-info') @endsection
@section('page-back-button') {{ route("admin.users.index") }} @endsection

@section('page-content')
<div class="form-container content-width-medium users-form-content js-ak-delete-container" data-delete-modal-action="{{ route("admin.users.delete") }}">
    <form method="POST"
          action="{{ isset($data->id) ? route('admin.users.update', $data->id) : route('admin.users.store') }}"
          enctype="multipart/form-data"
          class="form-page validate-form"
          novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>

        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('users_delete')
                    @if(isset($data->id))
                        <a href="#" data-id="{{ $data->id }}" class="delete-link js-ak-delete-link" draggable="false">
                            @includeIf("admin/admin_layout/partials/misc/icons/delete_icon")
                        </a>
                    @endif
                @endcan
            </div>
        </div>

        @includeIf("admin.admin_layout.partials.form.errors")

        <div class="form-content">

            {{-- Name --}}
            <div class="row-100 el-box-text">
                <div class="input-container">
                    <div class="input-label">
                        <label for="name">Full Name<span class="required">*</span></label>
                    </div>
                    <div class="input-data">
                        <input type="text" class="form-input" id="name" name="name" placeholder="Full Name"
                               value="{{ old('name', $data->name ?? '') }}" autocomplete="off">
                        <div class="error-message @if ($errors->has('name')) show @endif">
                            {{ trans('admin/form.required_text') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Email --}}
            <div class="row-100 el-box-text">
                <div class="input-container">
                    <div class="input-label">
                        <label for="email">Email Address<span class="required">*</span></label>
                    </div>
                    <div class="input-data">
                        <input type="email" class="form-input" id="email" name="email" placeholder="Email"
                               value="{{ old('email', $data->email ?? '') }}" autocomplete="off" required>
                        <div class="error-message @if ($errors->has('email')) show @endif">
                            {{ trans('admin/form.required_text') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Password --}}
            <div class="row-100 el-box-text">
                <div class="input-container">
                    <div class="input-label">
                        <label for="password">
                            Password @if(!isset($data->id))<span class="required">*</span>@endif
                        </label>
                    </div>
                    <div class="input-data">
                        <input type="password" class="form-input" id="password" name="password"
                               placeholder="Password" autocomplete="off">
                        <div class="error-message @if ($errors->has('password')) show @endif">
                            {{ trans('admin/form.required_text') }}
                        </div>
                        <div class="text-muted" id="password_help">
                            @if(isset($data->id))
                                Leave blank if you don't want to change the password.
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @includeIf("admin.admin_layout.partials.form.footer", ["cancel_route" => route("admin.users.index")])
    </form>
</div>

@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection
