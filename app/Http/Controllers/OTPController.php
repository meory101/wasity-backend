<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use App\Models\DeliveryManModel;
use App\Models\OTPModel;
use Illuminate\Http\Request;

/**
 * Eng Nour Othman
 */
class OTPController extends Controller
{
    public function generateOTP(Request $request)
    {
        // request 
        // number
        // type 0 is client 1 is delivery
        $otp = new OTPModel;
        $otp_code = random_int(100000, 999999);
        if ($request->type == 0) {
            $client =  new ClientModel;
            $client = $client->where('number', $request->number)->first();
            if (!$client) {
                $client =  new ClientModel;
                $client->number = $request->number;
                $client->save();
            }
            $otp->client_id
                = $client->id;
        }
        if ($request->type == 1) {
            $delivery_man =  new DeliveryManModel;
          $delivery_man=  $delivery_man->where('number', $request->number)->first();
            if (!$delivery_man) {
                $delivery_man =  new DeliveryManModel;
                $delivery_man->number = $request->number;
                $delivery_man->save();
            }
            $otp->delivery_man_id
                = $delivery_man->id;


        }
        if ($otp->client_id || $otp->delivery_man_id) {
            $otp->otp_code = $otp_code;
            $result = $otp->save();
            if ($result) {
                return response()->json($otp, 200);
            }
        }


        return response()->json([], 500);
    }


    
    //test
}
