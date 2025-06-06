@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.categories.index") }}">Sub Category</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Categories
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.categories.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium categories-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.categories.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.categories.update", $data->id)}}@else{{route("admin.categories.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('categories_delete')
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
                            <label for="catname">Name<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="catname" autocomplete="off"
                                   name="catname" required placeholder="catName"
                                   value="{{{ old('catname', $data->catname??'') }}}">
                            <div class="error-message @if ($errors->has('catname')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="catname_help"></div>
                        </div>
                    </div>
                </div>

				 
				 <div class="row-100 el-box-select-search">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="catid">Category<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
								<select class="form-select  js-ak-select2" id="catid"
                                    data-placeholder="{{trans("admin/form.select")}}" data-width="100%"  data-allow-clear="false" data-search-url="{{route("admin.categories.categories_auto_complete")}}"
                                    name="catid" required>
									@if($data->categoriesToValue)
                                    <option value="{{ $data->categoriesToValue->id }}" {{ (old('catid') ? old('catid') : $data->name ?? '') == $data->categoriesToValue->id ? 'selected' : '' }}>{{$data->categoriesToValue->name}} </option>
                                @endif
									
                            </select>
                            <div class="error-message @if ($errors->has('catid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="catid_help"></div>
                        </div>
                    </div>
                </div>


				

				
				
                <div class="row-100 el-box-select-custom">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="status">status</label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="status" name="status" >
                                <option value="">{{trans("admin/form.select")}}</option>
								@foreach($data::STATUS_CONS as $value => $label)
                                    <option value="{{ $value }}" {{ (old('status') ? old('status') : $data->status ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('status')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="status_help"></div>
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
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.categories.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection