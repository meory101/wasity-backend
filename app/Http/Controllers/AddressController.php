<?php

namespace App\Http\Controllers;

use App\Models\AddressModel;
use Faker\Provider\ar_EG\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function addAddress(Request $request)
    {
        $address = new AddressModel;
        $address->name = $request->name;
        $address->lat = $request->lat;
        $address->long = $request->long;
        $address->client_id = $request->client_id;
        $address = $address->save();
        if ($address) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }

    public function getAddressesByClientId($id)
    {
        $addresses =  AddressModel::where('client_id', $id)->get();
        if ($addresses) {

            return response()->json($addresses, 200);
        }

        return response()->json([], 500);
    }


    public function updateAddress(Request $request)
    {
        $address =  AddressModel::where('client_id', $request->id)->first();
        if ($address) {
            $address->lat = $request->lat;
            $address->long = $request->long;
            if ($request->name) {
                $address->name = $request->name;
            }

            $address = $address->save();
            if ($address) {
                return response()->json([], 200);
            }
        } else {
            return response()->json(['message' => 'address not found'], 401);
        }

        return response()->json([], 500);
    }
}
