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
                <table class="table js-ak-content js-ak-ajax-content" id="stockreport_table">
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
                @forelse($stockreports_list_all as $data)
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

    <a href="#" data-id="{{$data->id}}" class="view-stock-report-summery" data-url="{{ route('admin.stockreports.index') }}" draggable="false">
        @includeIf("admin/admin_layout/partials/misc/icons/show_icon")
    </a>

    {{-- Admin Confirmation Button --}}

    @if( ($LoggedInUserRole == 'Administator') && ($data->admin_confirmed == 0))
   <a href="#" class="btn btn-success btn-sm confirm-order-btn"
        data-id="{{ $data->id }}"
        data-url="{{ route('admin.stockreports.index') }}"    
            {{ $data->admin_confirmed ? 'disabled' : '' }}>
            @includeIf("admin/admin_layout/partials/misc/icons/confirm_new_icon")
    </a>
   
    @endif
   
    @if($data->admin_confirmed == 0)              
    <a href="#" data-id="{{$data->id}}"  style="display:inline-block" data-userid="{{$data->admin_id}}"
                            class="delete-stock-report" data-url="{{ route('admin.stockreports.index') }}" 
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
     <div id="customModal" class="custom-modal stockReportViewDetails">
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
						<th>Stock Imported By</th>
						<th>productId</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand Name</th>
                        <th>Part Description</th>
						<th>stockInHand</th>
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
            <a id="exportStockReportExcel" href=""  class="btn-close">Export Excel</a>
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
