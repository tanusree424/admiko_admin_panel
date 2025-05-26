@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">StockReports</li>
@endsection
@section('page-title')
StockReports
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">

	@can("stockreports_access")
    @fragment("stockreports_fragment")
	<div class="content-layout content-width-full stockreports-data-content js-ak-DataTable js-ak-ajax-DataTable-container js-ak-content-layout"
        data-id="stockreports"
		data-ajax-call-url="{{route("admin.stockreports.index")}}"
        data-delete-modal-action="{{route("admin.stockreports.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container js-ak-ajax-search" ><input name="stockreports_source" value="stockreports" type="hidden"/><input name="stockreports_length" value="{{Request()->query("stockreports_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="stockreports_search" value="{{(Request()->query("stockreports_source") == "stockreports")?Request()->query("stockreports_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("stockreports_source") == "stockreports" && Request()->query("stockreports_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @canany('stockreports_create')
                        <a href="{{route('admin.stockreports.create')}}" class="button primary-button add-new" draggable="false">
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
						<th class="table-id" data-sort-method="number">ID</th>
						<th>Stock Imported By</th>
						<th>productId</th>
						<th class=" table-col-hide-sm">stockInHand</th>
						<th class=" table-col-hide-sm">createdTime</th>
						<th class=" table-col-hide-sm">excelId</th>
                        @canany(['stockreports_edit','stockreports_delete'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">

                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="">
                @forelse($stockreports_list_all as $data)
                    <tr>
						<td>
							{{$data->id}}
						</td>
						<td>
							{{ (isset($data->userInfo->name)) ? $data->userInfo->name : ''}}
						</td>
						<td>
							{{$data->productid}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->stockinhand}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->createdtime}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->excelid}}
						</td>
                        @canany(['stockreports_edit','stockreports_delete'])
                        <td class="manage-td">
                            <div class="manage-links">
                                @can('stockreports_edit')
                                    <a href="{{route("admin.stockreports.edit", $data->id)}}" class="edit-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/edit_icon")</a>
                            @endcan
                                @can('stockreports_delete')
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
