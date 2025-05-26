<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class salesReportExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $salesReport = DB::table('products as p')
        ->select('p.partcode','p.partdescription','c.catname')
        ->join('categories as c','p.category','=','c.id')
        ->where('p.status','Active')
        ->get();

        return collect($salesReport);
    }

    public function headings(): array
    {
        return ['Part Code','Part Description','Category','Invoice Number','Invoice Date',
        'Month','Week','Customer Name','Location','Channel','Qty','Original Unit Price','Gross Amount'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:M')->getFont()->setSize(12); // To Perform Sheet styling
            },
        ];
    }
}
