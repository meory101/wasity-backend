<?php

namespace App\Http\Controllers;

use App\Models\MainBranchModel;
use Illuminate\Http\Request;

class MainBranchController extends Controller
{
    public function addMainBranch(Request $request)
    {

        $mainBranch = new MainBranchModel;
        $mainBranch->name = $request->name;
        if (MainBranchModel::where('name', $request->name)->first()) {
            return response()->json(['message' => 'name is taken'], 401);
        }
        if (!$request->hasFile('image')) {
            return response()->json(['message' => 'image is required'], 401);
        }

        $image = $request->file('image')->store('public');
        $mainBranch->image = basename($image);

        $mainBranch = $mainBranch->save();

        if ($mainBranch) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }
}
