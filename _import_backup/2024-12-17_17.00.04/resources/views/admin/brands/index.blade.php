@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">Brands</li>
@endsection
@section('page-title')
Brands
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">
    
	@can("brands_access")
    @fragment("brands_fragment")
	<div class="content-layout content-width-full brands-data-content js-ak-DataTable js-ak-ajax-DataTable-container js-ak-content-layout"
        data-id="brands"
		data-ajax-call-url="{{route("admin.brands.index")}}"
        data-delete-modal-action="{{route("admin.brands.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container js-ak-ajax-search" ><input name="brands_source" value="brands" type="hidden"/><input name="brands_length" value="{{Request()->query("brands_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="brands_search" value="{{(Request()->query("brands_source") == "brands")?Request()->query("brands_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("brands_source") == "brands" && Request()->query("brands_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @canany('brands_create')
                        <a href="{{route('admin.brands.create')}}" class="button primary-button add-new" draggable="false">
                            @includeIf("admin/admin_layout/partials/misc/icons/add_new_icon")
                            {{trans('admin/table.add_new')}}
                        </a>
                        @endcanany
                    </div>
                </div>
            </div>
            <div class="content table-content">
                <div class="ajax-spinner js-ak-ajax-spinner">
                    <div class="ajax-spinner-action">
                        @includeIf("admin.admin_layout/partials/misc/loading")
                    </div>
                </div>
                <table class="table js-ak-content js-ak-ajax-content">
                <thead>
                    <tr data-sort-method='thead'>
						<th>brandId</th>
						<th>brandName</th>
						<th>status</th>
						<th class=" table-col-hide-sm">createdBy</th>
						<th class=" table-col-hide-sm">createdTime</th>
                        @canany(['brands_edit','brands_delete'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">
                                
                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="">
                @forelse($brands_list_all as $data)
                    <tr>
						<td>
							{{$data->brandid}}
						</td>
						<td>
							{{$data->brandname}}
						</td>
						<td>
							{{$data->status}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->createdby}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->createdtime}}
						</td>
                        @canany(['brands_edit','brands_delete'])
                        <td class="manage-td">
                            <div class="manage-links">
                                @can('brands_edit')
                                    <a href="{{route("admin.brands.edit", $data->id)}}" class="edit-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/edit_icon")</a>
                            @endcan
                                @can('brands_delete')
                                <a href="#" data-id="{{$data->id}}" class="delete-link js-ak-delete-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/delete_icon")</a>
                                @endcan
                            </div>
                        </td>
                        @endcanany
                    </tr>
                @empty
                    
                @endforelse
                </tbody>
            </table>
            </div>
            <div class="content-footer">
                <div class="left">
                    <div class="change-length js-ak-table-length-DataTable"></div>
                </div>
                <div class="right">
                    <div class="content-pagination">
                        <nav class="pagination-container">
                            <div class="pagination-content">
                                <div class="pagination-info js-ak-pagination-info"></div>
                                <div class="pagination-box-data-table js-ak-pagination-box"></div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
	@includeIf("admin.admin_layout.partials.delete_modal_confirm_ajax")
    </div>
	@endfragment
	@endcan

	
	@includeIf("admin.admin_layout.partials.delete_modal_confirm")
</div>
@endsection