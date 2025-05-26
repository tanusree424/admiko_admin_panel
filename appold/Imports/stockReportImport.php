<?php

namespace App\Imports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Admin\StockUploadPreview;
use Carbon\Carbon;

class stockReportImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $orderId;
    protected $validateOnly;

    public function __construct($orderId = null, $validateOnly = false)
    {
        $this->orderId = $orderId;
        $this->validateOnly = $validateOnly;
    }

    public function collection(Collection $rows)
    {
        // Skip insert during validation
        if ($this->validateOnly) {
            return;
        }

        foreach ($rows as $index => $row) {
            if (empty($row['part_code']) || empty($row['stock_in_hand'])) {
                \Log::warning("Row ".($index+2)." skipped: Required fields missing.");
                continue;
            }

            StockUploadPreview::create([
                'part_code'      => $row['part_code'],
                'stock_in_hand'  => $row['stock_in_hand'],
                'orderid'        => $this->orderId,
                'created_at'     => Carbon::now(),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.part_code' => 'required',
            '*.stock_in_hand' => 'required|numeric|gt:0',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.part_code.required' => 'Part code is required.',
            '*.stock_in_hand.required' => 'Stock in hand is required.',
            '*.stock_in_hand.numeric' => 'Stock in hand must be a number.',
            '*.stock_in_hand.gt' => 'Stock in hand must be greater than zero.',
        ];
    }
}

/*
namespace App\Imports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Admin\StockUploadPreview;
use Carbon\Carbon;
use DB;

class stockReportImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $orderId;



    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Manual empty check
            if (empty($row['part_code']) || empty($row['stock_in_hand'])) {
                \Log::warning("Row ".($index+2)." skipped: Required fields missing.");
                continue; // skip empty row
            }

            StockUploadPreview::create([
                'part_code' => $row['part_code'],
                'stock_in_hand' => $row['stock_in_hand'],
                'orderid' => $this->orderId,
                'created_at' => Carbon::now(),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.part_code' => 'required',
            '*.stock_in_hand' => 'required|numeric|gt:0',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.part_code.required' => 'Part code is required.',
            '*.stock_in_hand.required' => 'Stock in hand is required.',
            '*.stock_in_hand.numeric' => 'Stock in hand must be a number.',
            '*.stock_in_hand.gt' => 'Stock in hand must be greater than zero.',
        ];
    }
}
*/