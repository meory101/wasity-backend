<?php

namespace App\Http\Controllers;

use App\Models\MainBranchModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainBranchController extends Controller
{



    public function getMainBranches()
    {
        $mainBranchs =  MainBranchModel::all();
        if ($mainBranchs) {
            return response()->json($mainBranchs, 200);
        }

        return response()->json([], 500);
    }
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


    public function updateMainBranch(Request $request)
    {
        $mainBranch =  MainBranchModel::find($request->id);
        if ($mainBranch) {
            if ($request->name) {

                if (MainBranchModel::where('name', $request->name)->first()) {
                    return response()->json(['message' => 'name is taken'], 401);
                }
                $mainBranch->name = $request->name;
            }
            if ($request->image) {
                Storage::delete('public/' . $mainBranch->image);

                $image = $request->file('image')->store('public');
                $mainBranch->image = basename($image);
            }

            $subBranch =  $mainBranch->save();
            if ($subBranch) {
                return response()->json([], 200);
            }
        } else {
            return response()->json([], 401);
        }

        return response()->json([], 500);
    }
}
