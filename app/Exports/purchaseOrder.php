<?php

namespace App\Exports;

use App\Models\Products;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class purchaseOrder implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    public function collection()
    {
        $purchaseOrders = DB::table('products as p')
                        ->select('p.partcode','p.partdescription','c.catname','pcm.price','p.MOQ')
                        ->join('categories as c','p.category','=','c.id')
                        ->join('product_country_mapping as pcm','p.id','=','pcm.products')
                        ->where('p.status','Active')
                        ->get();

        return collect($purchaseOrders);
    }

    public function headings(): array
    {
        return ['Part Code','Part Description','Category','Billing Price','MOQ','Order Qty'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:G')->getFont()->setSize(12);
            },
        ];
    }
}
