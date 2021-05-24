<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    } 
   
    public function update($id)
    { 
        request()->validate([
            'user_id'=>['required'],
            'account_type'=>['required'],
            'account_name'=>['required'], 
            'account_number'=>['required'], 
            'account_status'=>['required'],
            'transaction_pin'=>['required'],
            'bank_name'=>['required'],
            'bank_code'=>['required'],
            'phone'=>['required'],
         ]);  
        $accounts=Account::find($id);  
        $accounts->update(
            request()->except('transaction_pin')
         ); 
        if(request()->transaction_pin==NULL){
             $accounts->update(
               ['transaction_pin' => Hash::make(request()->transaction_pin)]

         ); 
        }

        return response()->json(['message' => 'Successfully updated','data'=> $accounts],200); 
    }
 
    public function getUser($id)
    {
        $data=Account::where('wallet_id',$id)
        ->where('user_id','!=',auth()->user()->id)
        ->with('user')->first();   
        if(!$data)
        {
        return response()->json(['message' => 'Details not found','data'=> $data],404);  
        }
        return response()->json(['message' => 'Successfully updated','data'=> $data],200); 
    } 
}
