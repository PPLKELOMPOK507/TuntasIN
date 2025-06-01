<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function history()
    {
        // Dummy sales data
        $sales = [
            [
                'id' => 1,
                'buyer_name' => 'John Doe',
                'service_name' => 'Web Development',
                'amount' => 500000,
                'status' => 'completed',
                'date' => '2024-03-15'
            ],
            [
                'id' => 2,
                'buyer_name' => 'Jane Smith',
                'service_name' => 'Logo Design',
                'amount' => 250000,
                'status' => 'pending',
                'date' => '2024-03-14'
            ],
            [
                'id' => 3,
                'buyer_name' => 'Mike Johnson',
                'service_name' => 'Content Writing',
                'amount' => 150000,
                'status' => 'cancelled',
                'date' => '2024-03-13'
            ]
        ];

        return view('sales.history', ['sales' => $sales]);
    }
}