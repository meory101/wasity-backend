<?php

namespace App\Http\Controllers;

use App\Models\SubBranchModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubBranchCotroller extends Controller
{


    public function getSubBranchesByMainBranchId($id)
    {
        $subBranchs = SubBranchModel::where('main_branch_id', $id)->get();
        if ($subBranchs) {
            return response()->json($subBranchs, 200);
        }
        return response()->json([], 500);
    }


    
    public function addSubBranch(Request $request)
    {

        $subBranch = new SubBranchModel;
        if (SubBranchModel::where('name', $request->name)->first()) {
            return response()->json(['message' => 'name is taken'], 401);
        }
        if (!$request->hasFile('image')) {
            return response()->json(['message' => 'image is required'], 401);
        }

        $image = $request->file('image')->store('public');
        $subBranch->image = basename($image);
        $subBranch->name = $request->name;
        $subBranch->lat = $request->lat;
        $subBranch->long = $request->long;
        $subBranch->active_status = $request->active_status;
        $subBranch->main_branch_id = $request->main_branch_id;
        $subBranch->manager_id = $request->manager_id;
        $subBranch = $subBranch->save();

        if ($subBranch) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }



    public function updateSubBranch(Request $request)
    {
        $subBranch =  SubBranchModel::find($request->id);
        if ($subBranch) {
            if ($request->name) {

                if (SubBranchModel::where('name', $request->name)->first()) {
                    return response()->json(['message' => 'name is taken'], 401);
                }
                $subBranch->name = $request->name;
            }
            if ($request->image) {
                Storage::delete('public/' . $subBranch->image);

                $image = $request->file('image')->store('public');
                $subBranch->image = basename($image);
            }

            if ($request->lat) {
                $subBranch->lat = $request->lat;
            }
            if ($request->long) {
                $subBranch->long = $request->long;
            }
            if ($request->active_status) {
                $subBranch->active_status = $request->active_status;
            }

            $subBranch =  $subBranch->save();
            if ($subBranch) {
                return response()->json([], 200);
            }
        } else {
            return response()->json([], 401);
        }

        return response()->json([], 500);
    }
}
