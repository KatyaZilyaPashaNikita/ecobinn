<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function showOrder() {
        $orders = Order::all();
        return view('/book', compact('orders'));
    }

    public function createOrder(Request $request) {
        Order::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'address' => $request -> address
        ]);
        return redirect('/book');
    }
}
