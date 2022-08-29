<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths
{    
    public function collection()
    {

        $orders = Order::all();

        foreach($orders as $order){
            if($order->status === 'paid'){
                $purchasedProducts = Product::whereIn('id', unserialize($order->products))->get();
                $order->products = $purchasedProducts->pluck('title');
                }
        }
       
        return $orders;
    }

    public function map($orders): array
    {
        return [
            
            $orders->name_buyer,
            $orders->email,
            $orders->message,
            ('€ ' . $orders->total),
            $orders->created_at ,
            $orders->products
        ];
    }

    public function headings(): array
    {
        return [
            'Naam koper',
            'Email',
            'Boodschap',
            'Totaal',
            'Gekocht op',
            'Producten'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 55,
            'D' => 10,
            'E' => 20,
            'F' => 100,            
        ];
    }
}
