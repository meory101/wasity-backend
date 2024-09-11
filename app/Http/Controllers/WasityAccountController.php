<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use App\Models\WasityAccountModel;
use Illuminate\Http\Request;

class WasityAccountController extends Controller
{
    public function changeBalance(Request $request)
    {
        //type 0 client 1 sub branch owner 
        //
        //
        if ($request->type == 0) {
            $account =  WasityAccountModel::where('client_id', $request->client_id)->first();
            $account->balance += $request->balance;
            $account->save();
            return response()->json([], 200);
        }
        if ($request->type == 1) {
            $account =  WasityAccountModel::where('manager_id', $request->manager_id)->first();
            $account->balance += $request->balance;
            $account->save();
            return response()->json([], 200);
        }
        return response()->json([], 500);
    }

    public function getAccount(Request $request)
    {
        //type 0 client 1 sub branch owner 
        //
        //
        if ($request->type == 0) {
            $account =  WasityAccountModel::where('client_id', $request->client_id)->first();

            return response()->json($account, 200);
        }
        if ($request->type == 1) {
            $account =  WasityAccountModel::where('manager_id', $request->manager_id)->first();
            return response()->json($account, 200);
        }
        return response()->json([], 500);
    }

    public function getUsers()
    {
        $users = ClientModel::all();
        if ($users) {

            return response()->json($users, 200);
        }
        return response()->json([], 500);
    }
}
