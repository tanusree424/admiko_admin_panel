@extends("admin.admin_layout.default")

@section('breadcrumbs')
    <li class="breadcrumb-item active">Report</li>
@endsection

@section('page-title')
    Stock Transfer Report
@endsection

@section('page-info')
    Overview of inventory, transfers, and order quantities per product.
@endsection

@section('page-back-button')
@endsection

@section('page-content')
<div class="page-content-width-full">
    @can("reports_access")
    @fragment("stockreports_fragment")

    <div class="content-layout content-width-full stockreports-data-content js-ak-DataTable js-ak-ajax-DataTable-container js-ak-content-layout"
        data-id="stockreports"
        data-ajax-call-url="{{route("admin.stockreports.index")}}"
        data-delete-modal-action="{{route("admin.stockreports.delete")}}">

       <div class="content-element d-flex flex-wrap gap-4 justify-content-between align-items-start">
    <!-- Stock Report Chart -->
    <div class="chart-box flex-fill" style="min-width: 300px; max-width: 48%;">
        <div class="content-header">
            <div class="header">
                <h3>Stock Report Pie Chart</h3>
                <p class="info">Visual distribution of inventory, transfers and orders</p>
            </div>
        </div>
        <div class="content-body">
            <canvas id="stockPieChart" style="height: 300px;"></canvas>
        </div>
    </div>

    <!-- Most Ordered Products Chart -->
    <div class="chart-box flex-fill" style="min-width: 300px; max-width: 48%;">
        <div class="content-header">
            <div class="header">
                <h3>Most Ordered Products</h3>
                <p class="info">Top products based on order count</p>
            </div>
        </div>
        <div class="content-body">
            <canvas id="orderedPieChart" style="height: 300px;"></canvas>
        </div>
    </div>
</div>
<!-- Bar Chart Section Below -->
<div class="content-element mt-5">
    <div class="content-header">
        <div class="header">
            <h3>Most Ordered Products (Bar Chart)</h3>
            <p class="info">Product-wise order volumes visualized</p>
        </div>
    </div>
    <div class="content-body">
        <canvas id="orderedBarChart" style="height: 400px;"></canvas>
    </div>
</div>



    @endfragment
    @endcan
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('stockPieChart');
        if (!ctx) {
            console.warn("Canvas element not found.");
            return;
        }

        const labels = @json($report->pluck('name'));
        const dataValues = @json($report->map(fn($item) =>
            $item->total_inventory + $item->total_transferred + $item->total_orders
        ));

        console.log("Labels:", labels);
        console.log("Data:", dataValues);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Inventory + Transferred + Orders',
                    data: dataValues,
                    backgroundColor: [
                        '#36A2EB', '#FF6384', '#FFCE56',
                        '#4BC0C0', '#9966FF', '#FF9F40',
                        '#E7E9ED', '#FF6384', '#36A2EB', '#FFCE56'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.formattedValue;
                            }
                        }
                    }
                }
            }
        });
    });
    // ordered pie chart
    const orderCtx = document.getElementById('orderedPieChart');
    const orderedChart = new Chart(orderCtx, {
        type: 'pie',
        data: {
            labels: @json($report->pluck('name')),
            datasets: [{
                label: 'Order Count',
                data: @json($report->pluck('total_orders')),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56',
                    '#4BC0C0', '#9966FF', '#FF9F40',
                    '#E7E9ED', '#8A2BE2', '#20B2AA', '#FFD700'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.formattedValue + ' orders';
                        }
                    }
                }
            }
        }
    });
     // Bar Chart for Orders
        const barCtx = document.getElementById('orderedBarChart');
        if (barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: @json($report->pluck('name')),
                    datasets: [{
                        label: 'Total Orders',
                        data: @json($report->pluck('total_orders')),
                        backgroundColor: '#36A2EB',
                        borderColor: '#1E88E5',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Order Count'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.formattedValue;
                                }
                            }
                        }
                    }
                }
            });
        }

</script>
@endpush

