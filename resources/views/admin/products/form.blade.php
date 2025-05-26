@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.products.index") }}">Products</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Products
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.products.index") }}@endsection
@section('page-content')
<div class="form-container content-width-medium products-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.products.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.products.update", $data->id)}}@else{{route("admin.products.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('products_delete')
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
            
               
				 <div class="row-100 el-box-select">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="subcategory">Category</label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="subcategory" name="subcategory" >
                                <option value="">{{trans("admin/form.select")}}</option>
								@foreach($data->subcategoryListAll() as $row)
                                    <option value="{{ $row->id }}" {{ (old('subcategory') ? old('subcategory') : $data->subcategory ?? '') == $row->id ? 'selected' : '' }}>{{ $row->name }} </option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('subcategory')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="subcategory_help"></div>
                        </div>
                    </div>
                </div>

				 <div class="row-100 el-box-select">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="category">Sub Category</label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="category" name="category" >
                                <option value="">{{trans("admin/form.select")}}</option>
								@foreach($data->categoryListAll() as $row)
                                    <option value="{{ $row->id }}" {{ (old('category') ? old('category') : $data->category ?? '') == $row->id ? 'selected' : '' }}>{{ $row->catname }} </option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('category')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="category_help"></div>
                        </div>
                    </div>
                </div>


                <div class="row-100 el-box-select">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="brand">Brand</label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="brand" name="brand" >
                                <option value="">{{trans("admin/form.select")}}</option>
								@foreach($data->brandListAll() as $row)
                                    <option value="{{ $row->id }}" {{ (old('brand') ? old('brand') : $data->brand ?? '') == $row->id ? 'selected' : '' }}>{{ $row->brandname }} </option>
                                @endforeach
                            </select>
                            <div class="error-message @if ($errors->has('brand')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="brand_help"></div>
                        </div>
                    </div>
                </div>

                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="productname">productName<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="productname" autocomplete="off"
                                   name="productname" required placeholder="productName"
                                   value="{{{ old('productname', $data->productname??'') }}}">
                            <div class="error-message @if ($errors->has('productname')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="productname_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="partcode">partCode<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="partcode" autocomplete="off"
                                   name="partcode" required placeholder="partCode"
                                   value="{{{ old('partcode', $data->partcode??'') }}}">
                            <div class="error-message @if ($errors->has('partcode')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="partcode_help"></div>
                        </div>
                    </div>
                </div>
				<div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="eancode">EAN Code<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="eancode" autocomplete="off"
                                   name="eancode" required placeholder="eancode"
                                   value="{{{ old('eancode', $data->eancode??'') }}}">
                            <div class="error-message @if ($errors->has('eancode')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="eancode_help"></div>
                        </div>
                    </div>
                </div>
				<div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="hsncode">HSN Code<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="hsncode" autocomplete="off"
                                   name="hsncode" required placeholder="hsncode"
                                   value="{{{ old('hsncode', $data->hsncode??'') }}}">
                            <div class="error-message @if ($errors->has('hsncode')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="hsncode_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="MOQ">MOQ<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="MOQ" autocomplete="off"
                                   name="MOQ" required placeholder="Minimum Order Quantity"
                                   value="{{{ old('MOQ', $data->MOQ??'') }}}">
                            <div class="error-message @if ($errors->has('MOQ')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="MOQ_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="partdescription">partDescription</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="partdescription" autocomplete="off"
                                   name="partdescription"  placeholder="partDescription"
                                   value="{{{ old('partdescription', $data->partdescription??'') }}}">
                            <div class="error-message @if ($errors->has('partdescription')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="partdescription_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-text">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="excelid">excelId</label>
                        </div>
                        <div class="input-data">
                            <input type="text" class="form-input" id="excelid" autocomplete="off"
                                   name="excelid"  placeholder="excelId"
                                   value="{{{ old('excelid', $data->excelid??'') }}}">
                            <div class="error-message @if ($errors->has('excelid')) show @endif">{{trans('admin/form.required_text')}}</div>
                            <div class="text-muted" id="excelid_help"></div>
                        </div>
                    </div>
                </div>
                <div class="row-100 el-box-select-custom">
                    <div class="input-container">
                        <div class="input-label">
                            <label for="status">status<span class="required">*</span></label>
                        </div>
                        <div class="input-data">
                            <select class="form-select" id="status" name="status" required>
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
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.products.index")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection