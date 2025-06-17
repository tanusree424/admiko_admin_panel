@extends('admin.admin_layout.default')

{{-- ─── Breadcrumb and Title ─────────────────────────────────────────────── --}}
@section('breadcrumbs')
    <li class="breadcrumb-item active">Stock Transfer</li>
@endsection

@section('page-title')
    Stock Transfer
@endsection

{{-- ─── Extra Styles ─────────────────────────────────────────────────────── --}}
@section('styles')
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        #stockPieChart {
            max-width: 100%;
            height: 300px;
        }
    </style>
@endsection

{{-- ─── Main Page Content ────────────────────────────────────────────────── --}}
@section('page-content')
<div class="page-content-width-full">
    <div class="content-layout content-width-full stocktransfer-data-content">
        <div class="content-element">
            <div class="content-header mb-3">
                <h3 class="mb-0">Stock Transfer</h3>
                <p class="info">Manage your stock transfers</p>
            </div>

            <div class="content table-content">
                <table id="stockTransferTable" class="table display">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Sub-category</th>
                            <th>PO Qty</th>
                            <th>Inventory Stock</th>
                            <th>Rest Stock</th>
                            {{-- <th>AWB Number</th>
                            <th>Transfer Date</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stock_transfer_list as $row)
                            <tr>
                                <td>{{ $row->product_id }}</td>
                                <td>{{ $row->product_name }}</td>
                                <td>{{ $row->brandname }}</td>
                                <td>{{ $row->catname }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->purchaseorder_quantity }}</td>
                                <td>{{ $row->inventory_stock }}</td>
                                <td>{{ $row->rest_stock }}</td>
                                {{-- <td>{{ $row->AWB_number ?? '‑' }}</td>
                                <td>
                                    {{ $row->transfer_date ? \Carbon\Carbon::parse($row->transfer_date)->format('d‑m‑Y') : '‑' }}
                                </td> --}}
                                <td>
                                    @if($row->AWB_number && $row->transfer_date)
                                        <span class="badge bg-success">Transferred</span>
                                    @elseif($row->purchaseorder_quantity > $row->inventory_stock)
                                        <button type="button" class="btn btn-outline-danger" disabled title="Purchase-order quantity exceeds available inventory">
                                            Insufficient Stock
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-outline-success js-transfer-btn"
                                                data-product-id="{{ $row->product_id }}">
                                            Transfer
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ─── Bootstrap 5 Modal for Stock Transfer ─────────────────────────────── --}}
<div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="transferForm" method="POST" action="{{ route('admin.stock_upload.submit') }}">
            @csrf
            <input type="hidden" name="product_id" id="modal_product_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transferModalLabel">Stock Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="awb_number" class="form-label">AWB Number</label>
                        <input type="text"
                               class="form-control"
                               id="awb_number"
                               name="awb_number"
                               required
                               placeholder="STK-20250612-0012">
                    </div>

                    <div class="mb-3">
                        <label for="transfer_date" class="form-label">Transfer Date</label>
                        <input type="date"
                               class="form-control"
                               id="transfer_date"
                               name="transfer_date"
                               required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary" id="submitTransferBtn">
                        Submit Transfer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- ─── Scripts ───────────────────────────────────────────────────────────── --}}
@section('scripts')
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTables
            $('#stockTransferTable').DataTable();

            // Transfer button click opens Bootstrap 5 modal
            $('.js-transfer-btn').on('click', function () {
                const productId = $(this).data('product-id');
                $('#modal_product_id').val(productId);

                const modal = new bootstrap.Modal(document.getElementById('transferModal'));
                modal.show();
            });
        });
    </script>
@endsection
