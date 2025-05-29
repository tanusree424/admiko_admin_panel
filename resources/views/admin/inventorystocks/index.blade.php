@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">Inventory Stocks</li>
@endsection
@section('page-title')
Inventory Stocks
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">

	@can("inventorystock_access")
    @fragment("inventorystocks_fragment")
	<div class="content-layout content-width-full inventorystocks-data-content js-ak-DataTable js-ak-ajax-DataTable-container js-ak-content-layout"
        data-id="purchaseorders"
		data-ajax-call-url="{{route("admin.inventorystock.index")}}"
        data-delete-modal-action="{{route("admin.inventorystock.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container js-ak-ajax-search" ><input name="inventorystocks_source" value="inventorystocks" type="hidden"/><input name="purchaseorders_length" value="{{Request()->query("purchaseorders_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="inventorystock_search" value="{{(Request()->query("inventorystock_source") == "inventorystocks")?Request()->query("inventorystocks_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("inventorystocks_source") == "inventorystocks" && Request()->query("inventorystock_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @canany('inventorystock_create')
                        <a href="{{route('admin.inventorystock.create')}}" class="button primary-button add-new" draggable="false">
                            @includeIf("admin/admin_layout/partials/misc/icons/add_new_icon")
                            {{trans('admin/table.add_new')}}
                        </a>
                        @endcanany
                    </div>
                </div>
            </div>
            <div class="content table-content">
			<div class="row-100">
			<form method="GET" action="{{ route('admin.inventorystock.index') }}">
				<div class="left">
					<div class="row-50 el-box-date-range">
							<div class="input-container">
								<div class="date-range-container">
									<div class="input-label">
										<label for="date_start">Start Date{!!trans('admin/config/date_time_flatpickr.rangeSeparator')!!}End Date</label>
									</div>
									<div class="input-data">
										<div class="group-input date-time-group" id="ak_date_group_date_start">
											<input type="text" autocomplete="off"  data-start-field="date_start" data-end-field="date_end"
												   class="form-input js-ak-date-range-picker"
												   id="date_start" placeholder="Filter Between Date Range"
												   value="{{{ old('date_start', (Request::get('date_start')) ? Request::get('date_start') : '') }}}{!!trans('admin/config/date_time_flatpickr.rangeSeparator')!!}{{{ old('date_end', (Request::get('date_end')) ? Request::get('date_end') : '') }}}">
											<div class="input-suffix js-ak-calendar-icon" data-target="#date_start">
												@includeIf("admin/admin_layout/partials/misc/icons/calendar_icon")
											</div>
											<div class="error-message @if ($errors->has('date_start')) show @endif">{{trans('admin/form.required_text')}}</div>
										</div>
										<input type="hidden" name="date_start" id="date_start_input"
											   value="{{{ old('date_start', isset($data->date_start)?$data->getRawOriginal('date_start') : '') }}}">
										<input type="hidden" name="date_end" id="date_end_input"
											   value="{{{ old('date_end', isset($data->date_end)?$data->getRawOriginal('date_end') : '') }}}">
										<script>
											let date_start_date_end_disable_days = [];
										</script>
									</div>
								</div>
								<div class="text-muted" id="date_start_help"></div>
							</div>
						</div>
					</div>
					<div class="right">
					<div class="row-50">
						<button type="submit" name="action" class="button primary-button submit-button" style="margin:22px;" value="Filter">Filter</button>
					</div>
					</div>
				</form>
				</div>
                <div class="ajax-spinner js-ak-ajax-spinner">
                    <div class="ajax-spinner-action">
                        @includeIf("admin.admin_layout/partials/misc/loading")
                    </div>
                </div>
                <table class="table js-ak-content js-ak-ajax-content" id="inventorystocks_table">
                <thead>
                    <tr data-sort-method='thead'>
                        <th class="table-id" data-sort-method="number">ID</th>
						<th class="table-id" data-sort-method="number">Order Number</th>
                        <th>Name</th>
						<th class=" table-col-hide-sm">orderTime</th>
						<th class=" table-col-hide-sm">updatedTime</th>
                        {{-- <th class=" table-col-hide-sm">Inventory Stock</th> --}}
                        <th class=" table-col-hide-sm" >Action</th>
                    </tr>
                </thead>
                <tbody class="">

				@foreach($inventorystocks_list_all as $data)
    <tr>
        <td>{{$data->id}}</td>
        <td data-id="{{$data->id}}">
            {{$data->order_number}}
        </td>
        <td class="table-col-hide-sm">
            {{$data->admin_name}}
        </td>
        <td class="table-col-hide-sm">
            {{$data->created_at}}
        </td>
        <td class="table-col-hide-sm">
            {{$data->updated_at}}
        </td>
         {{-- <td class="table-col-hide-sm">
            {{$data->inventory_stock}}
        </td> --}}
        <td class="table-col-hide-md" style="min-width: 100px;">

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">

<a href="#" data-id="{{$data->id}}" style="display:inline-block" data-userid="{{$data->admin_id}}"
                            class="view-stock-summery" data-url="{{ route('admin.inventorystock.index') }}"
                            draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/show_icon")</a>

            {{-- Admin Confirmation Button --}}

            @if( ($LoggedInUserRole == 'Administator') && ($data->admin_confirmed == 0))
           <a href="#" class="btn btn-success btn-sm confirm-stock-btn"
                data-id="{{ $data->id }}"
                data-url="{{ route('admin.inventorystock.index') }}"
                    {{ $data->admin_confirmed ? 'disabled' : '' }}>
                    @includeIf("admin/admin_layout/partials/misc/icons/confirm_new_icon")
            </a>

            @endif

            @if($data->admin_confirmed == 0)
                      <a href="#" data-id="{{$data->id}}" data-userid="{{$data->admin_id}}"
                            class="delete-is-order" data-url="{{ route('admin.inventorystock.index') }}"
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
<!-- Custom Modal -->
<div id="customModal" class="custom-modal puchaseOrderViewDetails">
    <div class="custom-modal-content modal-xxl">
        <!-- Modal Header -->
        <div class="custom-modal-header">
            <h2>Inventory Stock Summary</h2>
            <span class="custom-modal-close">&times;</span>
        </div>

        <!-- Modal Body (scrollable) -->
        <div class="custom-modal-body">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Distributor</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand Name</th>
                        <th>Part Description</th>
                        <th>Order Time</th>
                        <th>Order Price</th>
                        <th>MOQ</th>
                        <th>Inventory stock</th>
                        <th>Updated Time</th>
                        <th>Excel ID</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- Modal Footer -->
        <div class="custom-modal-footer">
        <a id="exportPurchaseOrderPdf" href=""  class="btn-close">Export PDF</a>
            <a id="exportPurchaseOrderExcel" href=""  class="btn-close">Export Excel</a>
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
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(()=>{
      $("#inventorystocks_table").on('click', '.view-stock-summery', function() {
        let orderId = $(this).data('id');
        let url = $(this).data('url');
        let userId = $(this).data('userid');

        $("#exportPurchaseOrderExcel").attr("href", url+"/exportExcel/" + orderId);
        $("#exportPurchaseOrderPdf").attr("href", url+"/exportPdf/" + orderId + "/" + userId);
    $.ajax({
        url: "/admin/inventorystocks/" + orderId,
        type: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);

            let tableData = '';
            // Loop through the data and create table rows
            let count = 1;
            data.data.forEach(function(item){
              //  let highlightClass = item.orderqty < item.moq ? 'row-warning' : '';
                tableData+=`<tr class="">
                        <td>${item.id}</td>
                        <td>${item.distributor_name}</td>
                        <td>${item.partcode}</td>
                        <td>${item.productname}</td>
                        <td>${item.catname}</td>
                        <td>${item.brand_name}</td>
                        <td>${item.part_description}</td>
                        <td>${item.ordertime}</td>
                        <td>${item.orderprice}</td>
                        <td>${item.moq}</td>
                        <td>${item.inventory_stock}</td>
                        <td>${item.updatedtime}</td>
                        <td>${item.excelid}</td>
                    </tr>`;
            })


            $('.puchaseOrderViewDetails .custom-modal-body tbody').html(tableData);
            $('.puchaseOrderViewDetails').fadeIn(); // Show modal
        },
        error: function (xhr, status, error) {
            console.error("Error fetching order summary:", xhr.responseText);
        }
    });

});
$("#inventorystocks_table").on('click', '.delete-is-order', function() {
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/delete/${order_id}`;

    // Show a confirmation dialog
    if (confirm("Are you sure you want to delete this purchase order?")) {
        $.ajax({
            url: urlPost,
            type: "POST",
            dataType: "json",
            data: {
                order_id: order_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Reload the page or update the DOM if necessary
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    } else {
        // If the user cancels the confirmation
        console.log("Purchase Order deletion was canceled.");
    }
});
$("#inventorystocks_table").on('click', '.confirm-stock-btn', function() {
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/confirm/${order_id}`;

    // Show a confirmation dialog
    if (confirm("Are you sure you want to confirm this stock?")) {
        $.ajax({
            url: urlPost,
            type: "POST",
            dataType: "json",
            data: {
                order_id: order_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Reload the page or update the DOM if necessary
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    } else {
        // If the user cancels the confirmation
        console.log("stock confirmation was canceled.");
    }
});

    })
</script>

@endsection


