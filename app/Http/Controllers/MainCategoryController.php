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
    public function addMainCategory(Request $request)
    {
        $mainCategory = new MainCategoryModel;
        $mainCategory->name = $request->name;
        if (MainCategoryModel::where('name', $request->name)->first()) {
            return response()->json(['message' => 'name is taken'], 401);
        }
        if (!$request->file('image')) {
            return response()->json(['message' => 'image is required'], 401);
        }
        $image = $request->file('image')->store('public');
        $mainCategory->image = basename($image);
        $mainCategory = $mainCategory->save();

        if ($mainCategory) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }
}
