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
                <table class="table js-ak-content js-ak-ajax-content" id="salesreport_table">
                <thead>
                    <tr data-sort-method='thead'>
						<th class="table-id" data-sort-method="number">Order Number</th>
                        <th>Name</th>
						<th class=" table-col-hide-sm">orderTime</th>
						<th class=" table-col-hide-sm">updatedTime</th>
                        <th class=" table-col-hide-sm">Action</th>
                    </tr>
                </thead>
                <tbody class="">
                @forelse($salesreports_list_all as $data)
                    <tr>
						<td data-id="{{$data->id}}">
							{{$data->order_number}}
						</td>
                        <td  class=" table-col-hide-sm">
                            {{$data->admin_name}}
                        </td>
						<td class=" table-col-hide-sm">
							{{$data->created_at}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->updated_at}}
						</td>

                        <td class="table-col-hide-md" style="min-width: 100px;">

<div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">

    <a href="#" data-id="{{$data->id}}" class="view-sales-report-summery" data-url="{{ route('admin.salesreports.index') }}" draggable="false">
        @includeIf("admin/admin_layout/partials/misc/icons/show_icon")
    </a>

    {{-- Admin Confirmation Button --}}

    @if( ($LoggedInUserRole == 'Administator') && ($data->admin_confirmed == 0))
   <a href="#" class="btn btn-success btn-sm confirm-order-btn"
        data-id="{{ $data->id }}"
        data-url="{{ route('admin.salesreports.index') }}"    
            {{ $data->admin_confirmed ? 'disabled' : '' }}>
            @includeIf("admin/admin_layout/partials/misc/icons/confirm_new_icon")
    </a>
   
    @endif
   
    @if($data->admin_confirmed == 0)
              <a href="#" data-id="{{$data->id}}" data-userid="{{$data->admin_id}}"
                    class="delete-sales-order" data-url="{{ route('admin.salesreports.index') }}" 
                    draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/delete_icon")</a>

                    @endif


</div

</td>
</tr>
@endforeach
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






        <!-- Custom Modal -->
<div id="customModal" class="custom-modal salesReportViewDetails">
    <div class="custom-modal-content modal-xxl">
        <!-- Modal Header -->
        <div class="custom-modal-header">
            <h2>Sales Report Summary</h2>
            <span class="custom-modal-close">&times;</span>
        </div>

        <!-- Modal Body (scrollable) -->
        <div class="custom-modal-body">
            <table class="custom-table">
                <thead>
                    <tr data-sort-method='thead'>
						<th class="table-id" data-sort-method="number">ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand Name</th>
                        <th>Part Description</th>
						<th>distributorId</th>
						<th>invoiceNumber</th>
						<th>invoiceDate</th>
						<th>reportMonth</th>
						<th>week</th>
						<th>customerName</th>
						<th>location</th>
						<th>channel</th>
						<th>qty</th>
						<th>originalUnitPrice</th>
						<th>grossAmount</th>
						<th>createdTime</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- Modal Footer -->
        <div class="custom-modal-footer">
        <!-- <a id="exportPurchaseOrderPdf" href=""  class="btn-close">Export PDF</a> -->
            <a id="exportPSalesReportExcel" href=""  class="btn-close">Export Excel</a>
            <button id="modalCloseBtn" class="btn-close">Close</button>
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