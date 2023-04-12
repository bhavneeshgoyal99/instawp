<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class UserAuthController extends Controller
{
    //
    public function login(Request $request){
        try{
            $rules = [
                'email' => 'required|exists:users',
                'password' => 'required'
            ];

            $validate = Validator::make($request->input(), $rules);
            if($validate->fails()){
                return $this->apiFailure($validate->errors()->first());
            }

            if(Auth::attempt($request->input())){
                $user = Auth::user();
                $user['balance'] = (int) $user->userBalance();
                $user['token'] = $user->createToken('sdfsf')->accessToken;

                return $this->apiSuccess($user, 'Login Successful');
            }else{
                return $this->apiFailure('Invalid Credentials');
            }
        }catch(Exception $e){
            return $this->apiFailure($e->getMessage());
        }
    }
}
