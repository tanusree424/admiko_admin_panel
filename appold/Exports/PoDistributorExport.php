<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PoDistributorExport implements FromView
{
    public function __construct($productsList,$distributors,$orderedQtyDistWise,$orderedQtyPrdWise,$adminStock,$otherStock) {
        $this->products = $productsList;
        $this->distributors = $distributors;
        $this->orderedQtyDistWise = $orderedQtyDistWise;
        $this->orderedQtyPrdWise = $orderedQtyPrdWise;
        $this->adminStock = $adminStock;
        $this->otherStock = $otherStock;
    }

    public function view(): View
    {
        return view('admin.exports.po_distributor_filter', [
            'productsList' => $this->products,
            'distributors' => $this->distributors,
            'orderedQtyDistWise' => $this->orderedQtyDistWise,
            'orderedQtyPrdWise' => $this->orderedQtyPrdWise,
            'adminStock' => $this->adminStock,
            'otherStock' => $this->otherStock,
        ]);
    }
}
