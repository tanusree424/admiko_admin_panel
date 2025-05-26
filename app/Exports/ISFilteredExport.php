<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ISFilteredExport implements FromView
{

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('admin.exports.index', [
            'inventorystocks_list_all' => $this->data
        ]);
    }
}
