<?php

namespace App\Http\Controllers;

use App\Models\MainCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Eng Nour Othman
 */
class MainCategoryController extends Controller
{

    public function getMainCatgories()
    {
        $mainCategories = MainCategoryModel::all();
        if ($mainCategories) {
            return response()->json($mainCategories, 200);
        }
        return response()->json([], 500);
    }
    public function addMainCategory(Request $request)
    {
        $mainCategory = new MainCategoryModel;

        if (MainCategoryModel::where('name', $request->name)->first()) {
            return response()->json(['message' => 'name is taken'], 401);
        }
        if (!$request->file('image')) {
            return response()->json(['message' => 'image is required'], 401);
        }
        $mainCategory->name = $request->name;
        $image = $request->file('image')->store('public');
        $mainCategory->image = basename($image);
        $mainCategory = $mainCategory->save();

        if ($mainCategory) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }

    public function updateMainCatgory(Request $request)
    {

        $mainCategory =  MainCategoryModel::find($request->id);

        if ($request->name) {
            if (MainCategoryModel::where('name', $request->name)->first()) {
                return response()->json(['message' => 'name is taken'], 401);
            }
            $mainCategory->name = $request->name;
        }

        if ($request->file('image')) {
            Storage::delete('public/' . $mainCategory->image);
            $image = $request->file('image')->store('public');
            $mainCategory->image = basename($image);
        }
        $mainCategory = $mainCategory->save();

        if ($mainCategory) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }


    public function deleteMainCatgory(Request $request)
    {
        $mainCategory =  MainCategoryModel::find($request->id);
        $mainCategory = $mainCategory->delete();
        if ($mainCategory) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }
}
