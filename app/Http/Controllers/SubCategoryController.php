<?php

namespace App\Http\Controllers;

use App\Models\SubCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    public function addSubCategory(Request $request)
    {

        $subCategory = new SubCategoryModel;
        $subCategory->name = $request->name;
        if (SubCategoryModel::where('name', $request->name)->first()) {
            return response()->json(['message' => 'name is taken'], 401);
        }
        if (!$request->hasFile('image')) {
            return response()->json(['message' => 'image is required'], 401);
        }
        $image = $request->file('image')->store('public');
        $subCategory->image = basename($image);
        $subCategory->main_category_id = $request->main_category_id;
        $subCategory = $subCategory->save();

        if ($subCategory) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }


    public function getSubCategoriesByMainCategoryId($id)
    {
        $subCategories = SubCategoryModel::where('main_category_id', $id)->get();

        if ($subCategories) {
            return response()->json($subCategories, 200);
        }
        return response()->json([], 500);
    }


    public function updateSubCategory(Request $request)
    {

        $subCategory =  SubCategoryModel::find($request->id);

        if ($request->name) {
            if (SubCategoryModel::where('name', $request->name)->first()) {
                return response()->json(['message' => 'name is taken'], 401);
            }
            $subCategory->name = $request->name;
        }

        if ($request->file('image')) {
            Storage::delete('public/' . $subCategory->image);
            $image = $request->file('image')->store('public');
            $subCategory->image = basename($image);
        }
        $subCategory = $subCategory->save();

        if ($subCategory) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }


    public function deleteSubCategory(Request $request)
    {
        $subCategory =  SubCategoryModel::find($request->id);
        $subCategory = $subCategory->delete();
        if ($subCategory) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }
}
