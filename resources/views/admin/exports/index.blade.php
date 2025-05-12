<table class="table js-ak-content js-ak-ajax-content">
    <thead>
        <tr data-sort-method='thead'>
            <th class="table-id" data-sort-method="number">ID</th>
            <th>distributor</th>
            <th>productId</th>
            <th class=" table-col-hide-sm">orderTime</th>
            <th class=" table-col-hide-sm">orderPrice</th>
            <th class=" table-col-hide-sm">Moq</th>
            <th class=" table-col-hide-sm">orderQty</th>
            <th class=" table-col-hide-sm">updatedTime</th>
            <th class=" table-col-hide-sm">excelId</th>
        </tr>
    </thead>
    <tbody class="">
    @forelse($purchaseorders_list_all as $data)
        <tr @if(isset($data->product->MOQ) && $data->orderqty < $data->product->MOQ) style="background-color: #ffcccc;" @endif>
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
        </tr>
    @empty

    @endforelse
    </tbody>
</table>
