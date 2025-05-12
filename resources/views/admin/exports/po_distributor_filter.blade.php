<table class="table js-ak-content js-ak-ajax-content">
        <thead>
            <tr data-sort-method='thead'>
                <th class="table-id">Product Name</th>
                @foreach($distributors as $distributor)
                <th class="table-col-hide-sm">{{ $distributor }}</th>
                @endforeach
                <th>Total</th>
                <th>Stock In Hand (By Distributors)</th>
                <th>Stock In Hand (By Administator)</th>
            </tr>
        </thead>
        <tbody class="">
        @php
            $totalOrdered = 0;
            $totalStock = 0;
            $StockbyDistbutors = 0;
            $StockbyAdmin = 0;
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
                <td>
                    {{ (isset($adminStock[$data->partcode])) ? $adminStock[$data->partcode] : 'N/A' }}
                    @php
                        $StockbyAdmin += (isset($adminStock[$data->partcode])) ? $adminStock[$data->partcode] : 0;
                    @endphp
                </td>
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
                <td><b>{{ $StockbyAdmin }}</b></td>
            </tr>
        </tbody>
    </table>
