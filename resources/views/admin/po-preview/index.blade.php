@extends("admin.admin_layout.default")
@section('breadcrumbs')
<li class="breadcrumb-item active">PurchaseOrders</li>
@endsection
@section('page-title')
Purchase Orders Import Preview
@endsection
@section('page-content')
<div class="page-content-width-full">
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

                    </div>
                </div>
            </div>
            <div class="content table-content">
            <form method="POST" action="{{ route('admin.po_upload.submit') }}">
            @csrf
                <div class="ajax-spinner js-ak-ajax-spinner">
                    <div class="ajax-spinner-action">
                        @includeIf("admin.admin_layout/partials/misc/loading")
                    </div>
                </div>
                <table class="table js-ak-content js-ak-ajax-content">
                <thead>
                    <tr data-sort-method='thead'>
						<th>productId</th>
						<th class=" table-col-hide-sm">orderTime</th>
						<th class=" table-col-hide-sm">orderPrice</th>
                        <th class=" table-col-hide-sm">MOQ</th>
						<th class=" table-col-hide-sm">orderQty</th>
						<th class=" table-col-hide-sm">updatedTime</th>
						<th class=" table-col-hide-sm">excelId</th>
                    </tr>
                </thead>
                <tbody class="">
                @forelse($results as $data)
                <tr style="{{ $data->orderqty < $data->MOQ ? 'background-color: #ffcccb; color: black; font-weight: bold;' : '' }}">
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
							{{$data->MOQ}}
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
                    </tr>
                @empty

                @endforelse
                </tbody>
            </table>
            </div>
            <div class="content-footer">
                <div class="left">
                    <input type="submit" class="button primary-button submit-button" name="submit" value="Import">
                </div>
                <div class="right">
                    {{ $results->links() }}
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
