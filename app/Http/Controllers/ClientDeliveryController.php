<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use App\Models\DeliveryManModel;
use App\Models\MainCategoryModel;
use App\Models\OTPModel;
use App\Models\ProductModel;
use App\Models\SubCategoryModel;
use Illuminate\Http\Request;

/**
 * Eng Nour Othman
 */
class ClientDeliveryController extends Controller
{
    public function clientDeliveryLogin(Request $request)
    {


        // request 
        // number
        // type 0 is client 1 is delivery
        // otp_code

        $otp  = new OTPModel;

        if ($request->type == 0) {
            $client =  ClientModel::where('number', $request->number)->first();
            $otp = OTPModel::where('client_id', $client->id)->orderBy('created_at', 'desc')->first();
        }
        if ($request->type == 1) {
            $delivery_man =  DeliveryManModel::where('number', $request->number)->first();
            $otp = OTPModel::where('delivery_man_id', $delivery_man->id)->orderBy('created_at', 'desc')->first();
        }


        if ($otp) {
            if ($otp->otp_code == $request->otp_code) {

                if ($request->type == 0) {
                    return response()->json(['token' => $client->createToken('token')->plainTextToken], 200);
                }
                if ($request->type == 1) {
                    return response()->json(['token' => $delivery_man->createToken('token')->plainTextToken], 200);
                }
            } else {
                return response()->json(['message' => 'otp is wrong'], 401);
            }
        }

        return response()->json([], 500);
    }

    public function updateClientProfile(Request $request)
    {
        $client = ClientModel::find($request->id);
        if ($client) {
            if ($request->name) {
                $client->name  = $request->name;
            }
            if ($request->email) {
                $client->email  = $request->email;
            }
            if ($request->gender) {
                $client->gender  = $request->gender;
            }
            if ($request->birth_date) {
                $client->birth_date  = $request->birth_date;
            }
            $res = $client->save();
            if ($res) {
                return response()->json($client, 200);
            }
        } else {
            return response()->json([], 400);
        }
         
            return response()->json([], 500);
        
    }

    public function getClientProfile($id){
        $client = ClientModel::find($id);
        if ($client) {
            return response()->json($client, 200);
        }
        return response()->json([], 500);


    }

    public function clientHome(Request $request)
    {
        //main categories
        //new arrival items
        //most popular items
        //isImmediately true false

        // [
        //     "mainCategories" =>[],
        //     "newItems" =>[],
        //     "popularItems" =>[]
        // ]
        $message = [];

        $mainCategories = MainCategoryModel::all();
        $products = new ProductModel;
        for ($i = 0; $i < count($mainCategories); $i++) {
            $subCategories = SubCategoryModel::where('main_category_id', $mainCategories[$i]->id)->get();

            $newItems = $products->whereIn('sub_category_id', $subCategories->pluck('id'))->orderBy('created_at', 'desc')->get();

            if (count($newItems) > 0) {
                array_push($message, [
                    'mainCategory' => $mainCategories[$i],
                    'newItems' => $newItems,

                ]);
            }
        }


        if ($mainCategories && $newItems) {
            return response()->json($message, 200);
        }
        return response()->json([], 500);
    }
}
