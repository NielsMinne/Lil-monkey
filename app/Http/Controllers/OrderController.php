<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function export()
    {
        return Excel::download(new OrderExport, 'orders.xlsx');
    }
}
