<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class Inventorystock implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $data;

    public function collection()
    {
        $rawData = DB::table('products as p')
            ->select('p.partcode', 'p.partdescription', 'c.catname', 'pcm.price', 'p.MOQ')
            ->join('categories as c', 'p.category', '=', 'c.id')
            ->join('product_country_mapping as pcm', 'p.id', '=', 'pcm.products')
            ->where('p.status', 'Active')
            ->get();

        $this->data = $rawData->map(function ($item) {
            $order_qty = rand(1, 100); // Replace with real order quantity
            $order_value = $order_qty * $item->price;

            return [
                'partcode' => $item->partcode,
                'partdescription' => $item->partdescription,
                'catname' => $item->catname,
                'price' => $item->price,
                'MOQ' => $item->MOQ,
                // 'order_qty' => $order_qty,
                'order_value' => $order_value,
                '__highlight' => $order_qty < $item->MOQ,
            ];
        });

        // Return only the values you want in the Excel sheet
        return $this->data->map(function ($item) {
            return [
                $item['partcode'],
                $item['partdescription'],
                $item['catname'],
                $item['price'],
                $item['MOQ'],
                // $item['order_qty'],
                $item['order_value'],
            ];
        });
    }

    public function headings(): array
    {
        return ['Part Code', 'Part Description', 'Category', 'Billing Price', 'MOQ', 'Order Value'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $startRow = 2;

                foreach ($this->data as $index => $row) {
                    if (!empty($row['__highlight'])) {
                        $rowNumber = $startRow + $index;
                        $cellRange = "A{$rowNumber}:G{$rowNumber}";

                        $event->sheet->getStyle($cellRange)->applyFromArray([
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFFFCCCC'], // Light red
                            ],
                            'font' => [
                                'bold' => true,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ]);
                    }
                }
            },
        ];
    }

}
