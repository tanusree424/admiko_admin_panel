<?php

namespace App\Exports;

use App\Models\Products;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class Inventorystock implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    public function collection()
    {
       /* $purchaseOrders = DB::table('products as p')
                        ->select('p.partcode','p.partdescription','c.catname','sc.name','pcm.price','p.MOQ')
                        ->join('categories as c','p.category','=','c.id')
                        ->join('product_country_mapping as pcm','p.id','=','pcm.products')
->join('sub_categories as sc','p.subcategory','=','sc.id')

                        ->where('p.status','Active')
                        ->get();*/
$inventorystock = DB::table('products as p')
    ->select(
        'p.partcode',
        'p.partdescription',
        'c.catname',
        'sc.name as subcategory_name',
        DB::raw('MIN(pcm.price) as price'),
        'p.MOQ'
    )
    ->join('categories as c', 'p.category', '=', 'c.id')
    ->join('sub_categories as sc', 'p.subcategory', '=', 'sc.id')
    ->join('product_country_mapping as pcm', 'p.id', '=', 'pcm.products')
    ->where('p.status', 'Active')
  //  ->where('pcm.country_id', $countryId) // Optional filter
    ->groupBy('p.id', 'p.partcode', 'p.partdescription', 'c.catname', 'sc.name', 'p.MOQ')
    ->get();

        return collect($inventorystock);
    }

    public function headings(): array
    {
        return ['Part Code','Part Description','SubCategory','Category','Billing Price','MOQ','Inventory_stock'];
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
