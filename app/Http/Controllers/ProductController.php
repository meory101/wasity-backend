<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use App\Models\ProductModel;
use App\Models\RateModel;
use App\Models\SubBranchModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = ProductModel::all();

        if ($products) {
            return response()->json($products, 200);
        }
        return response()->json([], 500);
    }
    public function getProductsBySubCategoryId($id)
    {
        $products = ProductModel::where('sub_category_id', $id)->get();
        $message = [];
        for ($i = 0; $i < count($products); $i++) {
            array_push($message, [
                'product' => $products[$i],
                'brand' =>  BrandModel::find($products[$i]->brand_id),
                'rate' => RateModel::where('product_id', $products[$i]->id)->get()->pluck('value')->avg(),
                'subCategory' =>  $products[$i]->subCategory,
                'subBranch' =>  SubBranchModel::find($products[$i]->sub_branch_id),
            ]);
        }
        if ($products) {
            return response()->json($message, 200);
        }
        return response()->json([], 500);
    }






    public function getProductsBySubBranchId($id)
    {
        $products = ProductModel::where('sub_branch_id', $id)->get();


        $message = [];
        for ($i = 0; $i < count($products); $i++) {
            array_push($message, [
                'product' => $products[$i],
                'brand' =>  BrandModel::find($products[$i]->brand_id),
                'rate' => RateModel::where('product_id', $products[$i]->id)->get()->pluck('value')->avg(),
                'subCategory' =>  $products[$i]->subCategory,
                'subBranch' =>  SubBranchModel::find($products[$i]->sub_branch_id),
            ]);
        }
        if ($products) {
            return response()->json($message, 200);
        }
        return response()->json([], 500);
    }


    public function addProduct(Request $request)
    {

        if (!$request->hasFile('image')) {
            return response()->json(['message' => 'image is required'], 400);
        }
        $product = new ProductModel;

        $image = $request->file('image')->store('public');
        $product->image = basename($image);
        $product->name = $request->name;
        $product->desc = $request->desc;
        $product->price = $request->price;
        $product->size_type = $request->size_type;
        $product->count = $request->count;
        $product->brand_id = $request->brand_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->sub_branch_id = $request->sub_branch_id;
        $product = $product->save();
        if ($product) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }


    public function updateProduct(Request $request)
    {

        $product =  ProductModel::find($request->id);
        if ($product) {
            if ($request->name) {
                $product->name = $request->name;
            }
            if ($request->price) {
                $product->price = $request->price;
            }
            if ($request->image) {
                Storage::delete('public/' . $product->image);
                $image = $request->file('image')->store('public');
                $product->image = basename($image);
            }


            $product =  $product->save();
            if ($product) {
                return response()->json([], 200);
            }
        } else {
            return response()->json([], 400);
        }

        return response()->json([], 500);
    }



    public function deleteProduct(Request $request)
    {
        $product =  ProductModel::find($request->id);
        if ($product) {
            $product =  $product->delete();
            if ($product) {
                return response()->json([], 200);
            }
        } else {
            return response()->json(['message' => 'product not found'], 400);
        }

        return response()->json([], 500);
    }


    public function getMostReleventProducts(Request $request)
    {
        $message = [];
        $response = Http::asForm()->post('http://10.2.0.2:5000/api/getMostReleventProducts', ['searchQuery' => $request->searchQuery ?? ""]);
        $response =  json_decode(($response)['releventProducts'], true);
        $response =  $response['docno'];
        $ids = array_values($response);
        for ($i = 0; $i < count($ids); $i++) {
            $products =   ProductModel::where('id', $ids[$i])->get();
            array_push($message, [
                'product' => $products[$i],
                'brand' =>  BrandModel::find($products[$i]->brand_id),
                'rate' => RateModel::where('product_id', $products[$i]->id)->get()->pluck('value')->avg(),
                'subCategory' =>  $products[$i]->subCategory,
                'subBranch' =>  SubBranchModel::find($products[$i]->sub_branch_id),
            ]);
        }
        if ($message) {
            return response()->json(['message' => $message], 200);
        }
        return response()->json([], 500);
    }


    public function pricingProducts(Request $request)
    {
        if ($request->all == true) {
            $products = ProductModel::where('sub_branch_id', $request->sub_branch_id)->get();
            for ($i = 0; $i < count($products); $i++) {
                $products[$i]->price = $products[$i]->price + ($products[$i]->price * $request->percent);
                $products[$i]->save();
            }
            return response()->json([], 200);
        } else {
            for ($i = 0; $i < count($request->products); $i++) {
                $product = ProductModel::find($request->products[$i]);
                $product->price = $product->price + ($product->price * $request->percent);
                $product->save();
            }
            return response()->json([], 200);
        }
        return response()->json([], 500);
    }
}
