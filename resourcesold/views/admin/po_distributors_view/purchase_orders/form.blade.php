@extends("admin.admin_layout.default")
@section('breadcrumbs')
	<li class="breadcrumb-item"><a href="{{ route("admin.po_distributors_view") }}">PO Distributors View</a></li>
	<li class="breadcrumb-item"><a href="{{ route("admin.po_distributors_view") }}">Purchase Orders</a></li>
    @if(isset($data->id))
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active">{{trans('admin/form.breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('page-title')
Purchase Orders
@endsection
@section('page-info')@endsection
@section('page-back-button'){{ route("admin.po_distributors_view") }}@endsection
@section('page-content')
<div class="form-container content-width-medium purchase-orders-form-content js-ak-delete-container" data-delete-modal-action="{{route("admin.po_distributors_view.purchase_orders.delete")}}">
    <form method="POST" action="@isset($data->id){{route("admin.po_distributors_view.purchase_orders.update", $data->id)}}@else{{route("admin.po_distributors_view.purchase_orders.store")}}@endisset" enctype="multipart/form-data" class="form-page validate-form" novalidate>
        <div hidden>
            @isset($data->id) @method('PUT') @endisset
            @csrf
        </div>
        <div class="form-header">
            <h3>{{ isset($data->id) ? trans('admin/form.update') : trans('admin/form.add_new') }}</h3>
            <div class="form-delete-record">
                @can('purchase_orders_delete')
                    @if(isset($data->id))
                    <a href="#" data-id="{{$data->id}}" class="delete-link js-ak-delete-link" draggable="false">
                        @includeIf("admin/admin_layout/partials/misc/icons/delete_icon")
                    </a>
                    @endIf
                @endcan
            </div>
        </div>
        @includeIf("admin.admin_layout.partials.form.errors")
        <div class="form-content">
            
        </div>
        @includeIf("admin.admin_layout.partials.form.footer",["cancel_route"=>route("admin.po_distributors_view")])
    </form>
</div>
@isset($data->id)
    @includeIf("admin.admin_layout.partials.delete_modal_confirm")
@endisset
@endsection