<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class stockReportExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    
    public function collection()
{
    $stockReport = DB::table('products as p')
        ->select(
            'p.partcode',
            'p.partdescription',
            'c.catname',
            's.stockinhand'
        )
        ->join('categories as c', 'p.category', '=', 'c.id')
        ->join('stockreports as s', 'p.partcode', '=', 's.productid')
        ->where('p.status', 'Active')
        ->distinct() // Add distinct to fetch unique records
        ->get();

    return collect($stockReport);
}

    // public function collection()
    // {
    //     $stockReport = DB::table('products as p')
    //     ->select('p.partcode','p.partdescription','c.catname', 's.stockinhand')
    //     ->join('categories as c','p.category','=','c.id')
    //     ->join('stockreports as s','p.partcode','=','s.productid')
    //     ->where('p.status','Active')
    //     ->get();
    //     return collect($stockReport);
    // }

    public function headings(): array
    {
        return ['Part Code','Part Description','Category','Stock In Hand'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:D')->getFont()->setSize(12); // To Perform Sheet styling
            },
        ];
    }
}
