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
    protected $purchaseOrders;

    public function __construct(Collection $purchaseOrders)
    {
        $this->purchaseOrders = $purchaseOrders;
    }

    public function collection()
    {
        return $this->purchaseOrders->map(function ($order) {
            return [
                $order->id,
                $order->distributor_name,
                $order->partcode,
                $order->productname,
                $order->brand_name,
                $order->catname,
                $order->part_description,
                $order->ordertime,               
                $order->price,
                $order->moq,
                $order->orderqty,
 		$order->orderprice,
                $order->updatedtime,
                $order->excelid
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Distributor', 'Product ID','Product Name', 'Brand Name', 'Category', 'Part Description' ,'Order Time',  'Unit Price' , 'MOQ', 'Order Qty', 'Order Price', 'Updated Time', 'Excel ID'];
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
