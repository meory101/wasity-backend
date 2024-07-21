<?php

namespace App\Http\Controllers;

use App\Models\RateModel;
use Illuminate\Http\Request;

class RateController extends Controller
{
  public function  rateProduct(Request $request)
  {
    $rate = new RateModel;
    $rate->value = $request->value;
    $rate->product_id = $request->product_id;
    $rate->client_id = $request->client_id;
    $rate = $rate->save();

    if ($rate) {
      return response()->json([], 200);
    }

    return response()->json([], 500);
  }
}
