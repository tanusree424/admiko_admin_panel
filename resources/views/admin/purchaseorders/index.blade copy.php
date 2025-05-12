@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">PurchaseOrders</li>
@endsection
@section('page-title')
PurchaseOrders
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">

	@can("purchaseorders_access")
    @fragment("purchaseorders_fragment")
	<div class="content-layout content-width-full purchaseorders-data-content js-ak-DataTable js-ak-ajax-DataTable-container js-ak-content-layout"
        data-id="purchaseorders"
		data-ajax-call-url="{{route("admin.purchaseorders.index")}}"
        data-delete-modal-action="{{route("admin.purchaseorders.delete")}}">
        <div class="content-element">
            <div class="content-header">
                <div class="header">
                    <h3></h3>
                    <p class="info"></p>
                </div>
                <div class="action">
                    <div class="left">
                        <form class="search-container js-ak-ajax-search" ><input name="purchaseorders_source" value="purchaseorders" type="hidden"/><input name="purchaseorders_length" value="{{Request()->query("purchaseorders_length")}}" type="hidden"/>
                            <div class="search">
                                <input type="text" autocomplete="off" placeholder="{{trans('admin/table.search')}}" name="purchaseorders_search" value="{{(Request()->query("purchaseorders_source") == "purchaseorders")?Request()->query("purchaseorders_search")??"":""}}" class="form-input js-ak-search-input">
                                <button class="search-button" draggable="false">
                                    @includeIf("admin/admin_layout/partials/misc/icons/search_icon")
                                </button>
                                @if(Request()->query("purchaseorders_source") == "purchaseorders" && Request()->query("purchaseorders_search"))
                                    <div class="reset-search js-ak-reset-search">
                                        @includeIf("admin/admin_layout/partials/misc/icons/reset_search_icon")
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        @canany('purchaseorders_create')
                        <a href="{{route('admin.purchaseorders.create')}}" class="button primary-button add-new" draggable="false">
                            @includeIf("admin/admin_layout/partials/misc/icons/add_new_icon")
                            {{trans('admin/table.add_new')}}
                        </a>
                        @endcanany
                    </div>
                </div>
            </div>
            <div class="content table-content">
			<div class="row-100">
			<form method="GET" action="{{ route('admin.purchaseorders.index') }}">
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
					@if($purchaseorders_list_all->count() > 0)
						<button type="submit" name="action" class="button primary-button submit-button" style="margin:22px;" value="Export">Export Data</button>
					@endif
					</div>
					</div>
				</form>
				</div>
                <div class="ajax-spinner js-ak-ajax-spinner">
                    <div class="ajax-spinner-action">
                        @includeIf("admin.admin_layout/partials/misc/loading")
                    </div>
                </div>
                <table class="table js-ak-content js-ak-ajax-content">
                <thead>
                    <tr data-sort-method='thead'>
						<th class="table-id" data-sort-method="number">ID</th>
						<th>distributor</th>
						<th>productId</th>
						<th class=" table-col-hide-sm">orderTime</th>
						<th class=" table-col-hide-sm">orderPrice</th>
                        <th class=" table-col-hide-sm">MOQ</th>
						<th class=" table-col-hide-sm">orderQty</th>
						<th class=" table-col-hide-sm">updatedTime</th>
						<th class=" table-col-hide-sm">excelId</th>
                        @canany(['purchaseorders_edit','purchaseorders_delete'])
                        <th class="no-sort manage-th" data-orderable="false">
                            <div class="manage-links">

                            </div>
                        </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="">
                @forelse($purchaseorders_list_all as $data)
                    <tr style="{{ $data->orderqty < $data->product->MOQ ? 'background-color: #ffcccb; color: black; font-weight: bold;' : '' }}">
						<td>
							{{$data->id}}
						</td>
						<td>
							{{$data->distributorInfo->name}}
						</td>
						<td>
							{{$data->productid}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->ordertime}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->orderprice}}
						</td>
                        <td class=" table-col-hide-sm">
							{{$data->product->MOQ}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->orderqty}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->updatedtime}}
						</td>
						<td class=" table-col-hide-sm">
							{{$data->excelid}}
						</td>
                        @canany(['purchaseorders_edit','purchaseorders_delete'])
                        <td class="manage-td">
                            <div class="manage-links">
                                @can('purchaseorders_edit')
                                    <a href="{{route("admin.purchaseorders.edit", $data->id)}}" class="edit-link" draggable="false">@includeIf("admin/admin_layout/partials/misc/icons/edit_icon")</a>
                            @endcan
                                @can('purchaseorders_delete')
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
