<?php

namespace App\Requests\Admin\Inventorystock;

use Illuminate\Foundation\Http\FormRequest;

class InventorystockRequest extends FormRequest
{
    public function rules()
    {
        return [
            "distributorid" => [
                "string",
                "nullable",
                "max:255"
            ],
            "productid" => [
                "string",
                "nullable",
                "max:255"
            ],
            "ordertime" => [
                "string",
                "nullable",
                "max:255"
            ],
            "orderprice" => [
                "string",
                "nullable",
                "max:255"
            ],
            "orderqty" => [
                "string",
                "required",
                "max:255"
            ],
            "updatedtime" => [
                "string",
                "nullable",
                "max:255"
            ],
            "excelid" => [
                "string",
                "nullable",
                "max:255"
            ],
            "status" => [
                "nullable",
                "max:30"
            ]
        ];
    }

    public function attributes()
    {
        return [
            "distributorid" => "Distributor ID",
            "productid" => "Product ID",
            "ordertime" => "Order Time",
            "orderprice" => "Order Price",
            "orderqty" => "Order Quantity",
            "updatedtime" => "Updated Time",
            "excelid" => "Excel ID",
            "status" => "Status"
        ];
    }
}
