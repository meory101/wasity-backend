<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * Eng Nour Othman
 */
class OrderController extends Controller
{


    // pending 0 accepted by branch 1 on the way 2 deliverd 3
    //delivery type
    public function addOrder(Request $request)
    {
        $order = new OrderModel;
        $subTotal = 0;
        $order->order_number = str()->random(8);
        $order->status_code = 0;
        $order->client_id = $request->client_id;
        $order->delivery_man_id = $request->delivery_id;
        $order->address_id = $request->address_id;
        $order->save();
        for ($i = 0; $i < count($request->items); $i++) {
            $order_product = new OrderProductModel;
            $product =  ProductModel::where('id', $request->items[$i])->first();
            $subTotal += $product->price;
            $order_product->order_id = $order->id;
            $order_product->product_id = $request->items[$i];
            $order_product =   $order_product->save();
        }
        if ($order_product) {
            $order->sub_total = $subTotal;
            $order->save();
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }
}
