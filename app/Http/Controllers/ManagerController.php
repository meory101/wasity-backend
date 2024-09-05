<?php

namespace App\Http\Controllers;

use App\Models\ManagerModel;
use App\Models\SubBranchModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Eng Nour Othman
 */

// role 1 is super_admin   2 is wasity_manager   3 is sub_branch_owner
class ManagerController extends Controller
{
    public function addManager(Request $request)
    {

        if (ManagerModel::where('email', $request->email)->first()) {
            return response()->json(['message' => "email already in use"], 400);
        }
        $manager = new  ManagerModel;
        $manager->email = $request->email;
        $manager->password = Hash::make($request->password);
        $manager->role_id = $request->role_id;
        $manager = $manager->save();
        if ($manager) {
            return response()->json([], 200);
        }

        return response()->json([], 500);
    }



    public function managerLogin(Request $request)
    {

        // request 
        // email
        // password
        $manager = ManagerModel::where('email', $request->email)->first();
        if ($manager) {


            if (Hash::check($request->password, $manager->password)) {
                return response()->json(
                    [
                        'token' => $manager->createToken('token')->plainTextToken,
                        'manager_data'
                        => $manager
                    ],
                    200
                );
            }
        } else {
            return response()->json(
                ['message' => 'email is not found'],
                400
            );
        }

        return response()->json(
            ['message' => 'password is wrong'],
            400
        );
    }


    public function getSubBranchAccounts()
    {
        $accounts = ManagerModel::where('role_id', 3)->get();
        if ($accounts) {
            return response()->json(
                $accounts,
                200
            );
        }
        return response()->json(
            [],
            500
        );
    }

    public function getSubBranchByManagerId($id)
    {
        $subBranch = SubBranchModel::where('manager_id', $id)->first();
        if ($subBranch) {
            return response()->json(
                $subBranch,
                200
            );
        }
        return response()->json(
            [],
            500
        );
    }
}
