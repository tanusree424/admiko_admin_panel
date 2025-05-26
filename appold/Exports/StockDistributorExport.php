<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StockDistributorExport implements FromView
{
    public function __construct($productsList, $distributors, $orderedQtyDistWise, $orderedQtyPrdWise,$otherStock) {
        $this->products = $productsList;
        $this->distributors = $distributors;
        $this->orderedQtyDistWise = $orderedQtyDistWise;
        $this->orderedQtyPrdWise = $orderedQtyPrdWise;
     
        $this->otherStock = $otherStock;
    }

    public function view(): View
    {
        return view('admin.exports.stock_distributor_filter', [
            'productsList' => $this->products,
            'distributors' => $this->distributors,
            'orderedQtyDistWise' => $this->orderedQtyDistWise,
            'orderedQtyPrdWise' => $this->orderedQtyPrdWise,
           
            'otherStock' => $this->otherStock,
        ]);
    }
}
