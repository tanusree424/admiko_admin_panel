@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">SalesReports</li>
@endsection
@section('page-title')
SalesReports
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">
    
	@can("salesreports_access")
    @fragment("salesreports_fragment")
	<div class="content-layout content-width-full salesreports-data-content js-ak-DataTable js-ak-ajax-DataTable-container js-ak-content-layout"
        data-id="salesreports"
		data-ajax-call-url="{{route("admin.salesreports.index")}}"
        data-delete-modal-action="{{route("admin.salesreports.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container js-ak-ajax-search" ><input name="salesreports_source" value="salesreports" type="hidden"/><input name="salesreports_length" value="{{Request()->query("salesreports_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="salesreports_search" value="{{(Request()->query("salesreports_source") == "salesreports")?Request()->query("salesreports_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("salesreports_source") == "salesreports" && Request()->query("salesreports_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @canany('salesreports_create')
                        <a href="{{route('admin.salesreports.create')}}" class="button primary-button add-new" draggable="false">
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
						<th>id</th>
						<th>distributorId</th>
						<th>productId</th>
						<th class=" table-col-hide-sm">invoiceNumber</th>
						<th class=" table-col-hide-sm">invoiceDate</th>
						<th class=" table-col-hide-sm">reportMonth</th>
						<th class=" table-col-hide-sm">week</th>
						<th class=" table-col-hide-sm">customerName</th>
						<th class=" table-col-hide-sm">location</th>
						<th class=" table-col-hide-sm">channel</th>
						<th class=" table-col-hide-sm">qty</th>
						<th class=" table-col-hide-sm">originalUnitPrice</th>
						<th class=" table-col-hide-sm">grossAmount</th>
						<th class=" table-col-hide-sm">excelId</th>
						<th class=" table-col-hide-sm">createdTime</th>
                        @canany(['salesreports_edit','salesreports_delete'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">
                                
                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="">
                @forelse($salesreports_list_all as $data)
                    <tr>
						<td>
							{{$data->my_id}}
						</td>
						<td>
							{{$data->distributorid}}
						</td>
						<td>
							{{$data->productid}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->invoicenumber}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->invoicedate}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->reportmonth}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->week}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->customername}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->location}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->channel}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->qty}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->originalunitprice}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->grossamount}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->excelid}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->createdtime}}
						</td>
                        @canany(['salesreports_edit','salesreports_delete'])
                        <td class="manage-td">
                            <div class="manage-links">
                                @can('salesreports_edit')
                                    <a href="{{route("admin.salesreports.edit", $data->id)}}" class="edit-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/edit_icon")</a>
                            @endcan
                                @can('salesreports_delete')
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