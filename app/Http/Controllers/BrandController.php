<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use Illuminate\Http\Request;

/**
 * Eng Nour Othman
 */
class BrandController extends Controller
{

    public function addBrand(Request $request)
    {
        if (BrandModel::where('name', $request->name)->first()) {
            return response()->json(['message' => 'name is taken'], 401);
        }

        $brand = new BrandModel;
        $brand->name = $request->name;
        $brand = $brand->save();
        if ($brand) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }
}
