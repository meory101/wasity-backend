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

    // pending 0 accepted by branch 1 on the way 2 deliverd 3  rejected 4
    //delivery type  0 immdediatly 1 not 


    public function assignOrderToDelivery(Request $request)
    {

        $order = OrderModel::find($request->id);
        if (!$order) {
            return response()->json(['message' => 'order not found'], 400);
        }
        $order->delivery_man_id = $request->delivery_man_id;
        $order->status_code = $request->status_code;
        $order = $order->save();
        if ($order) {
            return response()->json([], 200);
        }
        return response()->json([], 500);
    }
    public function addOrder(Request $request)
    {
        $order = new OrderModel;
        $subTotal = 0;
        $order->order_number = str()->random(8);
        $order->status_code = 0;
        $order->delivery_type = $request->delivery_type;
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

    public function  updateOrderStatus(Request $request)
    {
        $order = OrderModel::find($request->id);
        if (!$order) {
            return response()->json(['message' => 'order not found'], 400);
        }
        $order->status_code = $request->status_code;
        $order = $order->save();
        if ($order) {
            return response()->json([], 200);
        }
        return response()->json([], 500);
    }
    public function cancelOrder(Request $request)
    {

        $order = OrderModel::find($request->id);
        if (!$order) {
            return response()->json(['message' => 'can not find order'], 200);
        }
        if ($order->status_code == 0 || $order->status_code == 1) {
            $order =  $order->status_code = 4;
            if ($order) {
                return response()->json([], 200);
            }
        } else {
            return response()->json(['message' => "you can not cancel order"], 400);
        }
        return response()->json([], 500);
    }
    public function getClientOrders($id)
    {
        $orders = OrderModel::where('client_id', $id)->get();
        if ($orders) {
            return response()->json($orders, 200);
        }
        return response()->json([], 500);
    }



    public function getDeliveredOrders($id)
    {
        $orders = OrderModel::where('delivery_man_id', $id)->where('status_code', 3)->get();
        if ($orders) {
            return response()->json($orders, 200);
        }
        return response()->json([], 500);
    }

    public function getAcceptedOrders()
    {
        $orders = OrderModel::where('status_code', 1)->get();
        if ($orders) {
            return response()->json($orders, 200);
        }
        return response()->json([], 500);
    }
}
