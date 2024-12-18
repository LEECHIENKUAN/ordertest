<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderCreated;
use App\Http\Requests\CreateOrderRequest;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function store(CreateOrderRequest $request)
    {
        // var_dump($request->get('address'));exit();
        event(new OrderCreated($request->validated()));
        return response()->json(['message' => 'Order processing started'], 200);
    }

    public function show($id)
    {
        // var_dump($id);

        $order = DB::table('orders_twd')->where('order_id', $id)->first() ?? DB::table('orders_usd')->where('order_id', $id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);

        // return response()->json(['message' => "Order {$id}"], 200);
    }

}
