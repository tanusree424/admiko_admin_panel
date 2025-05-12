@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">ProductStockLogs</li>
@endsection
@section('page-title')
ProductStockLogs
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">
    
	@can("productstocklogs_access")
    @fragment("productstocklogs_fragment")
	<div class="content-layout content-width-full productstocklogs-data-content js-ak-DataTable js-ak-ajax-DataTable-container js-ak-content-layout"
        data-id="productstocklogs"
		data-ajax-call-url="{{route("admin.productstocklogs.index")}}"
        data-delete-modal-action="{{route("admin.productstocklogs.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container js-ak-ajax-search" ><input name="productstocklogs_source" value="productstocklogs" type="hidden"/><input name="productstocklogs_length" value="{{Request()->query("productstocklogs_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="productstocklogs_search" value="{{(Request()->query("productstocklogs_source") == "productstocklogs")?Request()->query("productstocklogs_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("productstocklogs_source") == "productstocklogs" && Request()->query("productstocklogs_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @canany('productstocklogs_create')
                        <a href="{{route('admin.productstocklogs.create')}}" class="button primary-button add-new" draggable="false">
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
						<th>logId</th>
						<th>stockId</th>
						<th>quantity</th>
						<th class=" table-col-hide-sm">price</th>
						<th class=" table-col-hide-sm">comment</th>
						<th class=" table-col-hide-sm">updatedBy</th>
						<th class=" table-col-hide-sm">updatedTime</th>
                        @canany(['productstocklogs_edit','productstocklogs_delete'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">
                                
                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="">
                @forelse($productstocklogs_list_all as $data)
                    <tr>
						<td>
							{{$data->logid}}
						</td>
						<td>
							{{$data->stockid}}
						</td>
						<td>
							{{$data->quantity}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->price}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->comment}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->updatedby}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->updatedtime}}
						</td>
                        @canany(['productstocklogs_edit','productstocklogs_delete'])
                        <td class="manage-td">
                            <div class="manage-links">
                                @can('productstocklogs_edit')
                                    <a href="{{route("admin.productstocklogs.edit", $data->id)}}" class="edit-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/edit_icon")</a>
                            @endcan
                                @can('productstocklogs_delete')
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