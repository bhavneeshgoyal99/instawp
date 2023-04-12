<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cookies;
use App\Models\wallet_transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderCookiesController extends Controller
{
    //
    public function orderCookies(Request $request){
        try{
            $rules = [
                'cookies' => 'required|integer|min:3|max:100'
            ];

            $validator = Validator::make($request->input(), $rules);
            if($validator->fails()){
                return $this->apiFailure($validator->errors()->first());
            }

            $user = \Auth::user();
            $balance = (int) $user->userBalance();
            $cookies = (int) $request->input('cookies');
            $deductableAmout = 0;

            if($balance >= $cookies){
                $cookieOrder = Cookies::create(['user_id' => $user->id, 'cookies' => $cookies]);

                if($cookieOrder){
                    $deductableAmout -= $cookies;
                    $wallet = wallet_transactions::create(['amount' => $deductableAmout, 'user_id' => $user->id, 'txn_type' => 'debit']);

                    if($wallet){
                        return $this->apiSuccess(['new_balance' => (int) $user->userBalance()], 'Order Placed');
                    }else{
                        return $this->apiFailure('Order failed at wallet deduction');
                    }
                }else{
                    return $this->apiFailure('Server Error');
                }
            }

            return $this->apiFailure('Insufficient Balance');
        }catch(\Exception $e){
            return $this->apiFailure($e->getMessage());
        }
    }
}
