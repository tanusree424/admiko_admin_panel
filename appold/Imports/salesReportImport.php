<?php

namespace App\Imports;

use App\Models\Admin\Salesreports\Salesreports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Auth;
use DB;

class salesReportImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function parseExcelDate($value)
    {
        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }

            $formats = ['d-m-Y', 'd/m/Y', 'Y-m-d', 'Y/m/d', 'm/d/Y'];
            foreach ($formats as $format) {
                $date = Carbon::createFromFormat($format, trim($value));
                if ($date && $date->format($format) === trim($value)) {
                    return $date->format('Y-m-d');
                }
            }

            return Carbon::parse(trim($value))->format('Y-m-d');
        } catch (\Exception $e) {
            \Log::warning("Invalid date in Excel: " . json_encode($value));
            return null;
        }
    }

    public function model(array $row)
    {
        
		
         // Check if any required field is empty
    $requiredFields = [
        'part_code', 'invoice_number', 'invoice_date',
        'customer_name', 'location', 'channel',
        'qty', 'original_unit_price', 'gross_amount',
    ];

    foreach ($requiredFields as $field) {
        if (empty($row[$field])) {
            throw new \Exception("Missing value in required field: {$field}");
        }
    }

        $invoiceDate = $this->parseExcelDate($row['invoice_date']);

        return new Salesreports([
            'productid' => $row['part_code'],
            'invoicenumber' => $row['invoice_number'],
            'invoicedate' => $invoiceDate,
            'reportmonth' => $invoiceDate ? Carbon::parse($invoiceDate)->month : null,
            'week' => $invoiceDate ? Carbon::parse($invoiceDate)->week : null,
            'customername' => $row['customer_name'],
            'location' => $row['location'],
            'channel' => $row['channel'],
            'qty' => $row['qty'],
            'originalunitprice' => $row['original_unit_price'],
            'grossamount' => $row['gross_amount'],
            'createdtime' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'orderid' => $this->orderId,
            'distributorid' => Auth::id(),
            'created_by' => Auth::id(),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.part_code' => ['required'],
            '*.invoice_number' => ['required'],
            '*.invoice_date' => ['required'],
            '*.customer_name' => ['required'],
            '*.location' => ['required'],
            '*.channel' => ['required'],
            '*.qty' => ['required', 'numeric', 'min:1'],
            '*.original_unit_price' => ['required', 'numeric'],
            '*.gross_amount' => ['required', 'numeric'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.part_code.required' => 'Part Code is required.',
            '*.invoice_number.required' => 'Invoice Number is required.',
            '*.invoice_date.required' => 'Invoice Date is required.',
            '*.customer_name.required' => 'Customer Name is required.',
            '*.location.required' => 'Location is required.',
            '*.channel.required' => 'Channel is required.',
            '*.qty.required' => 'Quantity is required.',
            '*.qty.numeric' => 'Quantity must be a number.',
            '*.qty.min' => 'Quantity must be at least 1.',
            '*.original_unit_price.required' => 'Original Unit Price is required.',
            '*.original_unit_price.numeric' => 'Original Unit Price must be a number.',
            '*.gross_amount.required' => 'Gross Amount is required.',
            '*.gross_amount.numeric' => 'Gross Amount must be a number.',
        ];
    }
}