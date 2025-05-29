<?php

namespace App\Imports;

use App\Models\Admin\InventoryStockpreview;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;
use Auth;
use DB;

class InventorystocksImport implements ToModel, WithHeadingRow ,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function model(array $row)
    {


    // Define required fields
    $requiredFields = ['part_code', 'billing_price'];

    foreach ($requiredFields as $field) {
        if (!isset($row[$field]) || trim($row[$field]) === '') {
            throw new \Exception("The field '{$field}' is empty in the Excel row.");
        }
    }

        return new InventoryStockpreview([
    'distributorid' => Auth::id(),
    'productid' => $row['part_code'],
    'ordertime' => Carbon::now(),
    'orderprice' => $row['billing_price'], // removed
    'inventory_stock' => $row['inventory_stock'],
    'updatedtime' => Carbon::now(),
    'excelid' => 'IS Import',
    'status' => 'true',
    'orderid' => $this->orderId,
    'created_by' => Auth::id(),
]);

    }


    public function rules(): array{
    return [
        // '*.order_qty' => function ($attribute, $value, $fail) {
        //     // Extract the row index
        //     $rowIndex = explode('.', $attribute)[0];

        //     // Get the corresponding MOQ value from the same row
        //     $moq = request()->input("{$rowIndex}.moq");

        //     // Check if order_qty is null or empty
        //     if (is_null($value) || $value === '') {
        //         $fail("Row " . ($rowIndex + 1) . ": Order QTY cannot be empty.");
        //         return;
        //     }

        //     // Convert values to integers for comparison
        //     if (isset($moq) && (int) $value < (int) $moq) {
        //         $fail("Row " . ($rowIndex + 1) . ": Order QTY ({$value}) must be greater than or equal to MOQ ({$moq}).");
        //     }
        // }
    ];
}


    // public function rules(): array
    // {
    //     return ['*.order_qty' => 'gte:*.moq',];
    // }
}

