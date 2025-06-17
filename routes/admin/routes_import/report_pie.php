<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportController\StockReportController;

Route::get('stock-transfer-report', [StockReportController::class, 'index'])
    ->name('stock_transfer_report');
