<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class StockTemplate implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $productStock = DB::table('products as p')
        ->select('p.partcode','p.partdescription','c.catname')
        ->join('categories as c','p.category','=','c.id')
       // ->join('product_country_mapping as pcm','p.id','=','pcm.products')
        ->where('p.status','Active')
        ->get();

        return collect($productStock);
    }

    public function headings(): array
    {
        return ['Part Code','Part Description','Category','Stock In Hand'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:D')->getFont()->setSize(12);
            },
        ];
    }
}
