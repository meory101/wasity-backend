<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductsBySubCategoryId($id)
    {
        $products = ProductModel::where('sub_category_id', $id)->get();

        if ($products) {
            return response()->json($products, 200);
        }
        return response()->json([], 500);
    }


    public function addProduct(Request $request)
    {

        if (!$request->hasFile('image')) {
            return response()->json(['message' => 'image is required'], 401);
        }
        $product = new ProductModel;

       $image = $request->file('image')->store('public');
        $product->image = basename($image);
        $product->name = $request->name;
        $product->brand_id = $request->brand_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->sub_branch_id = $request->sub_branch_id;
        $product = $product->save();
        if ($product) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }
}
