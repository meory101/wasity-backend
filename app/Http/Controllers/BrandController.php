<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if (!$request->file('image')) {
            return response()->json(['message' => 'image is required'], 401);
        }


        $brand = new BrandModel;
        $image = $request->file('image')->store('public');
        $brand->image = basename($image);
        $brand->name = $request->name;
        $brand = $brand->save();
        if ($brand) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }


    public function getBrands()
    {
        $brands = BrandModel::all();
        if ($brands) {
            return response()->json($brands, 200);
        }
        return response()->json([], 500);
    }


    public function updateBrand(Request $request)
    {

        $brand =  BrandModel::find($request->id);

        if ($request->name) {
            if (BrandModel::where('name', $request->name)->first()) {
                return response()->json(['message' => 'name is taken'], 401);
            }
            $brand->name = $request->name;
        }

        if ($request->file('image')) {
            Storage::delete('public/' . $brand->image);
            $image = $request->file('image')->store('public');
            $brand->image = basename($image);
        }
        $brand = $brand->save();

        if ($brand) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }


    public function deleteBrand(Request $request)
    {
        $brand =  BrandModel::find($request->id);
        $brand = $brand->delete();
        if ($brand) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }
}
