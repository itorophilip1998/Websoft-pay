<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    } 
   
    public function update(Account $accounts)
    { 
         Validator::make(request()->all(),[
            'user_id'=>['required'],
            'account_type'=>['required'],
            'account_name'=>['required'],
            'account_balance'=>['required'],
            'account_status'=>['required'],
            'transaction_pin'=>['required'],
            'bank_name'=>['required'],
            'bank_code'=>['required'],
            'phone'=>['required'],
         ]);
        $accounts->update(request()->all());
        return response()->json(['message' => 'Successfully updated','data'=> $accounts],200);

    }

   
}
