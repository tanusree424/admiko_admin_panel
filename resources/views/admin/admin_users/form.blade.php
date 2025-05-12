@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.admin_users.index") }}">Users</a></li>
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
@section('page-back-button'){{ route("admin.admin_users.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium admin-users-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.admin_users.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.admin_users.update", $data->id)}}@else{{route("admin.admin_users.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('admin_users_delete')
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
                <div class="row-100 el-box-email">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="email">Email<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="email" autocomplete="off" class="form-input" id="email" name="email" required
                                   placeholder="Email"  value="{{{ old('email', $data->email??'') }}}">
                            <div class="error-message @if ($errors->has('email')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="email_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-image-cropper">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="image">Image<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            @if ($data->image)
                                <div>
                                    <a href="{{ $data->image }}" class="form-image-preview js-base64-image-preview js-ak-image-available">
                                        <img src="{{ $data->image }}">
                                    </a>
                                </div>
                                
                            @endif
                            <div class="cropper-content js-ak-cropper-container" style="display: none;max-width: 500px">
                                <div><img class="cropper-image js-ak-cropper-image"></div>
                                <div class="cropper-tools">
                                    @includeIf("admin.admin_layout.partials.form.cropper_tools")
                                </div>
                            </div>
                            <input type="hidden" class="js-ak-cropped-save" name="image" value="">
                            <input type="file" class="form-file js-ak-image-cropper-upload" data-id="image" accept=".jpg,.jpeg,.png,.webp" data-file-type=".jpg,.jpeg,.png,.webp"  data-max-width="200" @if(!isset($data) || !$data->image) required @endIf >
                            <input type="hidden" class="ak_image_current" name="ak_image_current" value="{{$data->image??''}}">
                            <div class="error-message @if ($errors->has('image')) show @endif" data-required="{{trans('admin/form.required_image')}}" data-size="{{trans('admin/form.required_size')}}" data-type="{{trans('admin/form.required_type')}}" data-size-type="{{trans('admin/form.invalid_size_or_type')}}">
                                @if ($errors->has('image')){{ $errors->first('image') }}@endif
                            </div>
                            <div class="text-muted" id="image_help">{{trans("admin/form.file_extension_limit")}}.jpg,.jpeg,.png,.webp. </div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-pass">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="password">Password</label>
                        </div>
                        <div class="input-data">
                            <input type="password" class="form-input" id="password" name="password" 
                                   placeholder="Password" autocomplete="new-password" value="">
                            <div class="error-message @if ($errors->has('password')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="password_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-select-custom">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="language">Language<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="language" name="language" required>
                                @foreach($data->getAdminLanguages() as $value => $label)
                                    <option value="{{ $value }}" {{ (old('language') ? old('language') : $data->language ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('language')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="language_help"></div>
                        </div>
                    </div>
                </div>

                <div class="row-100 el-box-checkbox">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="show_language">Show language</label>
                        </div>
                        <div class="input-data">
                            <div class="checkbox-input form-switch">
                                <input type="hidden" name="show_language" value="0">
                                <input class="form-checkbox" type="checkbox" id="show_language" name="show_language" value="1"
                                       @if(old("show_language") || ((isset($data->show_language)&&$data->show_language==1))) checked @endif >
                                <label class="form-check-label" for="show_language"></label>
                            </div>
                            <div class="text-muted" id="show_language_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-select-search">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="country">Country<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <select class="form-select  js-ak-select2" id="country"
                                    data-placeholder="{{trans("admin/form.select")}}" data-width="100%"  data-allow-clear="false" data-search-url="{{route("admin.admin_users.country_auto_complete")}}"
                                    name="country" required>
                                @if($data->countryToValue)
                                    <option value="{{ $data->countryToValue->id }}" {{ (old('country') ? old('country') : $data->country ?? '') == $data->countryToValue->id ? 'selected' : '' }}>{{$data->countryToValue->countryname}} </option>
                                @endif
                            </select>
                            <div class="error-message @if ($errors->has('country')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="country_help"></div>
                        </div>
                    </div>
                </div>


                <div class="row-100 el-box-select-custom">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="theme">Theme<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="theme" name="theme" required>
                                @foreach($data->getAdminThemes() as $value => $label)
                                    <option value="{{ $value }}" {{ (old('theme') ? old('theme') : $data->theme ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('theme')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="theme_help"></div>
                        </div>
                    </div>
                </div>

                <div class="row-100 el-box-checkbox">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="show_theme">Show theme</label>
                        </div>
                        <div class="input-data">
                            <div class="checkbox-input form-switch">
                                <input type="hidden" name="show_theme" value="0">
                                <input class="form-checkbox" type="checkbox" id="show_theme" name="show_theme" value="1"
                                       @if(old("show_theme") || ((isset($data->show_theme)&&$data->show_theme==1))) checked @endif >
                                <label class="form-check-label" for="show_theme"></label>
                            </div>
                            <div class="text-muted" id="show_theme_help"></div>
                        </div>
                    </div>
                </div>
                @if(isset($data) && $data->id == 1)
                <div class="input-container">
                    <div class="input-label">
                        <label for="permissions">Roles<span class="required">*</span></label>
                    </div>
                    <div class="input-data">
                        {{trans("admin/misc.admin_user_has_full_access")}}
                    </div>
                </div>
                @else
                <div class="row-100 el-box-multi-select">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="roles">Roles<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <select class="form-select js-ak-select2-many" id="roles"
                                data-placeholder="{{trans("admin/form.select")}}" multiple="multiple" data-width="100%"  data-allow-clear="false"
                                name="roles[]" required>
                                @foreach($data->rolesListAll() as $row)
                                    @php $selected = ""; @endphp
                                    @if(in_array($row->id, old('roles', [])))
                                        @php $selected = "selected"; @endphp
                                    @elseIf(isset($data->id) && $data->rolesMany->contains($row->id))
                                        @php $selected = "selected"; @endphp
                                    @endIf
                                    <option value="{{ $row->id }}" {{$selected}}>{{ $row->title }}</option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('roles')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="roles_help"></div>
                        </div>
                    </div>
                </div>
                @endif


                <div class="row-100 el-box-checkbox">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="active">Active</label>
                        </div>
                        <div class="input-data">
                            <div class="checkbox-input form-switch">
                                <input type="hidden" name="active" value="0">
                                <input class="form-checkbox" type="checkbox" id="active" name="active" value="1"
                                       @if(old("active") || ((isset($data->active)&&$data->active==1))) checked @endif >
                                <label class="form-check-label" for="active"></label>
                            </div>
                            <div class="text-muted" id="active_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-multi-select">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="multi_tenancy">Multi-Tenancy</label>
                        </div>
                        <div class="input-data">
                            <select class="form-select js-ak-select2-many" id="multi_tenancy" 
                                data-placeholder="{{trans("admin/form.select")}}" multiple="multiple" data-width="100%"  data-allow-clear="true"
                                name="multi_tenancy[]" >
                                @foreach($data->multiTenancyListAll() as $row)
                                    @if($row->id == $data->id) @continue @endif
									@php $selected = ""; @endphp
                                    @if(in_array($row->id, old('multi_tenancy', [])))
                                        @php $selected = "selected"; @endphp
                                    @elseIf(isset($data->id) && $data->multiTenancyMany->contains($row->id))
                                        @php $selected = "selected"; @endphp
                                    @endIf
                                    <option value="{{ $row->id }}" {{$selected}}>{{ $row->name }} </option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('multi_tenancy')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="multi_tenancy_help">Allow user to see records from selected users.</div>
                        </div>
                    </div>
                </div>


                <div class="row-100 el-box-select">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="team_id">Team</label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="team_id" name="team_id" >
                                <option value="">{{trans("admin/form.select")}}</option>
								@foreach($data->teamIdListAll() as $row)
                                    <option value="{{ $row->id }}" {{ (old('team_id') ? old('team_id') : $data->team_id ?? '') == $row->id ? 'selected' : '' }}>{{ $row->name }} </option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('team_id')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="team_id_help">Assign a user to a team.</div>
                        </div>
                    </div>
                </div>

        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.admin_users.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection