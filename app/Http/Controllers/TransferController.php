<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TransferController extends Controller
{
  
    public function store()
    { 
        request()->validate([
            'user_id'=>['required'], 
            'beneficiary'=>['required'],  
            'type'=>['required'],
            'amount'=>['required'], 
            'status'=>['required'],
            'tx_ref'=>['required'],
            'flw_ref'=>['required'],
            'transaction_id'=>['required'],
            'transaction_pin'=>['required']
         ]);  
         $paid=Transfer::create(request()->except('transaction_pin'));
         if ($paid) {
            $wallet=auth()->user()->accounts();
            $balance=$wallet->pluck('account_balance')[0];  
            $correct_pin=Hash::check(request()->transaction_pin, $wallet->pluck('transaction_pin')[0]);
            dd($correct_pin);
            if ($balance < request()->amount && $correct_pin) {
              $info=[ 
                    'message'=>"Insufficent Fund",
                    'status'=>false, 
                    'wallet'=>$wallet
                ];
               return response()->json($info, 400);  
            }  
            $deduct= $balance - request()->amount;
            $wallet->update([
                'account_balance'=>$deduct,
            ]); 
            $data=[
                'data'=>$paid,
                'message'=>"Created Successfully",
                'status'=>true,
                'wallet'=>$wallet
            ];
            return response()->json($data, 200); 
        } 
    }
 
   

  
}
