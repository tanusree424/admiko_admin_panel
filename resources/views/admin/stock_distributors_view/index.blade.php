@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">Stock Distributors View</li>
@endsection
@section('page-title')
Stock Distributors View
@endsection
@section('page-info')@endsection
@section('page-back-button')@endsection
@section('page-content')
<div class="page-content-width-full">
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
                <!--<form class="search-container js-ak-ajax-search" ><input name="brands_source" value="brands" type="hidden"/><input name="brands_length" value="{{Request()->query("brands_length")}}" type="hidden"/>
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
                </form>-->
            </div>
            <div class="right">

            </div>
        </div>
    </div>
    <div class="content table-content">
	<div class="row-100">
	<form method="GET" action="{{ route('admin.stock_distributors_view') }}">
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
				@if(count($distributors) > 0)
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
                <th class="table-id">Product Name</th>
				
                @foreach($distributors as $distributor)
                <th class="table-col-hide-sm">{{ $distributor }}</th>
                @endforeach
                <th>Total</th>
               <th>Stock In Hand (By Distributors)</th>
                <!-- <th>Stock In Hand (By Administator)</th>-->
            </tr>
        </thead>
        <tbody class="">
        @php
            $totalOrdered = 0;
            $totalStock = 0;
            $StockbyDistbutors = 0;
           // $StockbyAdmin = 0;
         @endphp
        @foreach($productsList as $data)
            <tr>
                <td>
                    {{ $data->productname }} ({{$data->partcode}})
                </td>
                @foreach($distributors as $distKey => $distributor)
                <td>
                    {{ isset($orderedQtyDistWise[$data->partcode][$distKey]) ?  $orderedQtyDistWise[$data->partcode][$distKey] : 'N/A' }}
                </td>
                @php
                    if(isset($orderedQtyDistWise[$data->partcode][$distKey])) {
                        $totalOrdered += $orderedQtyDistWise[$data->partcode][$distKey];
                    }
                @endphp
                @endforeach
                <td>
                @php
                echo $totalOrdered;
                $totalOrdered = 0;
                @endphp
                </td>
               <td>
                    {{ (isset($otherStock[$data->partcode])) ? $otherStock[$data->partcode] : 'N/A' }}
                    @php
                        $StockbyDistbutors += (isset($otherStock[$data->partcode])) ? $otherStock[$data->partcode] : 0;
                    @endphp
                </td>
                <!--<td>
                    {{ (isset($adminStock[$data->partcode])) ? $adminStock[$data->partcode] : 'N/A' }}
                    @php
                        $StockbyAdmin = (isset($adminStock[$data->partcode])) ? $adminStock[$data->partcode] : 0;
                    @endphp
                </td>-->
            </tr>
        @endforeach
            <tr>
                <td>Total</td>
                @php
                    $productsTotal = 0;
                @endphp
                @foreach($orderedQtyPrdWise as $dkey => $total)
                @php
                    $productsTotal += $total;
                @endphp
                <td>{{ $total }}</td>
                @endforeach
                <td><b>{{ $productsTotal }}</b></td>
               <td><b>{{ $StockbyDistbutors }}</b></td> 
                
            </tr>
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
</div>
@endsection
