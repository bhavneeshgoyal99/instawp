<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\wallet_transactions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    public function addBalance(Request $request){
        try{
            $user = \Auth::user()->id;
            $rules = [
                'amount' => 'required|integer|min:1',
            ];

            $validate = Validator::make($request->input(), $rules);
            if($validate->fails()){
                return $this->apiFailure($validate->errors()->first());
            }

            $wallet = wallet_transactions::create(['user_id' => $user, 'amount' => (int) $request->input('amount'), 'txn_type' => 'credit']);
            if($wallet){
                $wallet = wallet_transactions::where('user_id', $user)->sum('amount');

                return $this->apiSuccess((int) $wallet, 'Balance Added');
            }

            return $this->apiFailure('Server Error');
        }catch(Exception $e){
            return $this->apiFailure($e->getMessage());
        }
    }

    public function getBalance(){
        try{
            $user = \Auth::user()->id;
            $wallet = wallet_transactions::where('user_id', $user)->sum('amount');

            return $this->apiSuccess((int) $wallet, 'Balance');
        }catch(Exception $e){
            return $this->apiFailure($e->getMessage());
        }
    }
}
