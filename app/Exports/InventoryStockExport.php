<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class PurchaseOrderExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $inventorystocks;

    public function __construct(Collection $inventorystocks)
    {
        $this->inventorystocks = $inventorystocks;
    }

    public function collection()
    {
        return $this->inventorystocks->map(function ($stock) {
            return [
                $stock->id,
                $stock->distributor_name,
                $stock->partcode,
                $stock->productname,
                $stock->brand_name,
                $stock->catname,
                $stock->part_description,
                $stock->ordertime,
                $stock->price,
                $stock->moq,
                // $stock->orderqty,
 		        $stock->orderprice,
                $stock->updatedtime,
                $stock->excelid
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Distributor', 'Product ID','Product Name', 'Brand Name', 'Category', 'Part Description' ,'Order Time',  'Unit Price' , 'MOQ',  'Order Price', 'Updated Time', 'Excel ID','Inventory Stock'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:I')->getFont()->setSize(12);
            },
        ];
    }
}
