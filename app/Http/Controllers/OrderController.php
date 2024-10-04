<?php

namespace App\Http\Controllers;

use App\Models\AddressModel;
use App\Models\ClientModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\ProductModel;
use App\Models\SubBranchModel;
use App\Models\WasityAccountModel;
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
        $client = ClientModel::find($request->client_id);
        if ($client->points <= 10) {
            return response()->json(['error' => 'This user cannot make an order'], 200);
        }

        $order = new OrderModel;
        $subTotal = 0;
        $order->order_number = str()->random(8);
        $order->status_code = 0;
        $order->delivery_type = $request->delivery_type;
        $order->client_id = $request->client_id;
        $order->address_id = $request->address_id;
        // $order->save();


        $items = json_decode($request->items, true);
        // $items = $request->items;
        if (!is_array($items)) {
            return response()->json(['error' => 'Invalid items format'], 400);
        }

        foreach ($items as $itemData) {
            $item = (object)$itemData;
            $product = ProductModel::find($item->id);
            // return $product;
            if ($product->count < $item->count) {
                return response()->json(['only' . $product->count . 'left'], 400);
            }
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            $subTotal += $product->price * $item->count;

            $acc = WasityAccountModel::where('client_id', $request->client_id)->first();
            if ($request->pay_type == 1) {
                $subBranch  = SubBranchModel::find($product->sub_branch_id);
                if ($subBranch) {
                    $account = WasityAccountModel::where('manager_id', $subBranch->manager_id)->first();
                    $account->balance += $product->price * $item->count;
                    $account->save();
                }

                if ($acc->balance >= $subTotal) {
                    $acc->balance -= $subTotal;
                    $acc->save();
                } else {
                    return response()->json(['error' => 'Insufficient balance'], 500);
                }
            }
            $order->save();
            $order_product = new OrderProductModel;
            $order_product->order_id = $order->id;
            $order_product->product_id = $item->id;
            $order_product->count = $item->count;
            $order_product->save();
            $product->count -= $item->count;
            $product->save();
        }

        $client->points += $subTotal / 100;
        $client->save();

        $order->sub_total = $subTotal;


        return response()->json(['message' => 'Order placed successfully'], 200);
    }

    public function updateOrderStatus(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'status_code' => 'required|integer',
        ]);

        $order = OrderModel::find($request->order_id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 400);
        }

        $order->status_code = $request->status_code;

        if ($order->save()) {
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
            $order->status_code = 5;
            $res = $order->save();
            if ($res) {
                // $order_products = 
                $client = ClientModel::find($request->user_id);
                $client->points -= ($order->sub_total / 10);
                $client->save();
                return response()->json([], 200);
            }
        } else {
            return response()->json(['message' => "you can not cancel order"], 400);
        }
        return response()->json([], 500);
    }
    public function getClientOrders($id)
    {
        $message = [];
        $orders = OrderModel::where('client_id', $id)->get();
        if ($orders) {
            for ($i = 0; $i < count($orders); $i++) {
                $products = [];
                $order_product  = OrderProductModel::where('order_id', $orders[$i]->id)->get();
                for ($j = 0; $j < count($order_product); $j++) {
                    array_push($products, ProductModel::find($order_product[$j]->product_id));
                }
                array_push($message, [
                    'order' => $orders[$i],
                    'products' => $products
                ]);
            }
            return response()->json($message, 200);
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

    public function getSubBranchOrders($id)
    {
        $message = [];
        $myProducts = ProductModel::where('sub_branch_id', $id)->get();

        $orders = [];

        foreach ($myProducts as $product) {
            $order_products = OrderProductModel::where('product_id', $product->id)->get();

            foreach ($order_products as $order_product) {
                $order = OrderModel::find($order_product->order_id);

                if (!isset($orders[$order->id])) {
                    $orders[$order->id] = [
                        'order' => $order,
                        'products' => [],
                    ];
                }

                $orders[$order->id]['products'][] = $product;
            }
        }

        foreach ($orders as $order) {
            $message[] = [
                'order' => $order['order'],
                'products' => $order['products'],
                'order_product' => OrderProductModel::where('order_id', $order['order']->id)->get()
            ];
        }

        return $message;
    }
    public function getDeliveryOrders(Request $request)
    {
        // size type  vehicle type
        $suitableCar = [
            '1' => ['1', '2', '3'],
            '2' => ['2', '3'],
            '3' => ['2', '3', '4'],
            '4' => ['4', '5']
        ];
        //size guide 1 small 2 mid 3 big 4 larg
        //  1 -> cycle  if value is more than 500k go with RC PC
        //  2 -> RC 
        //  3 -> PC
        //  4 -> van
        //  5 -> truck
        $product = new ProductModel;
        $orders = OrderModel::where('status_code', '0')->get();
        $message = [];
        if ($orders) {
            for ($i = 0; $i < count($orders); $i++) {
                $canDeliver = true;
                $products = [];
                $order_products = OrderProductModel::where('order_id', $orders[$i]->id)->get();
                for ($j = 0; $j < count($order_products); $j++) {
                    $product = ProductModel::find($order_products[$j]->product_id);
                    $subBranch = SubBranchModel::find($product->sub_branch_id);
                    array_push($products, ['product' =>
                    $product, 'branch' => $subBranch]);
                    if (
                        !isset($suitableCar[$product->size_type]) ||
                        !in_array($request->vehicle_id, $suitableCar[$product->size_type])
                    ) {
                        $canDeliver = false;
                        break;
                    }
                }
                if ($canDeliver == true) {
                    array_push($message, ['orderDetails' => [
                        'order' => $orders[$i],
                        'products' => $products,
                        'client' => ClientModel::find($orders[$i]->client_id),
                        'address' => AddressModel::find($orders[$i]->address_id)

                    ]]);
                }
            }
            return response()->json((
                ["result" => $message]
            ), 200);
        }
        return response()->json([], 500);
    }
}
