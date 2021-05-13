<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transfer;
use App\Models\Transactions;
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
            'transaction_pin'=>['required'] ,
            'user'=>['required'],
            'bank_name'=>['required']
         ]);  
         $paid=Transfer::create(request()->except('transaction_pin'));
         if ($paid) {
            $wallet=auth()->user()->accounts();
            $balance=$wallet->pluck('account_balance')[0];  
            $correct_pin=Hash::check(request()->transaction_pin, $wallet->pluck('transaction_pin')[0]); 
            if ($balance < request()->amount) {
              $info=[ 
                    'message'=>"Insufficent Fund",
                    'status'=>false, 
                    'wallet'=>$wallet
                ];
               return response()->json($info, 400);  
            }  
            elseif (!$correct_pin) {
                $info=[ 
                    'message'=>"Invalid Pin",
                    'status'=>false, 
                    'wallet'=>$wallet
                ];
               return response()->json($info, 401);  
            }

            if(request()->type=='wallet'){  
               $beneficiary=Account::where('wallet_id',request()->beneficiary)->first();
               $add= $beneficiary->account_balance + request()->amount;   
                $beneficiary->update([
                    'account_balance'=>$add 
                    ]);
            }
            $deduct= $balance - request()->amount;
            $wallet->update([
                'account_balance'=>$deduct,
            ]); 
           
            $transactions=$this->transaction(
                request()->user_id,
                auth()->user()->accounts()->pluck('id')[0],
                request()->beneficiary,
                request()->user,
                request()->type,
                request()->amount,
                'Transfered '.request()->amount.' to '.request()->user.' '.request()->status,
                "paid",  
                'Successful',
                request()->tx_ref,
                request()->transaction_id
            );  
            $data=[
                'data'=>$paid,
                'transaction'=>$transactions,
                'message'=>"Created Successfully",
                'status'=>true,
                'wallet'=>$wallet
            ]; 
            return response()->json($data, 200); 
        } 
    }
 
    public function transaction(
        $user_id,$account_id,$beneficiary,
        $beneficiary_name,$transaction_type,
        $amount,$status_from_user,$status_from_transaction,
        $status,$reference_no,$transaction_id
    )
    {
        $paid=Transactions::create([ 
             'user_id'=>$user_id,
             'account_id'=>$account_id,
             'beneficiary'=>$beneficiary,
             'beneficiary_name'=>$beneficiary_name,
             'transaction_type'=>$transaction_type,
             'amount'=>$amount,
             'status_from_user'=>$status_from_user,
             'status_from_transaction'=>$status_from_transaction,
             'status'=>$status,
             'reference_no'=>$reference_no,
             'transaction_id'=>$transaction_id
        ]);
        return $paid;
    }
    public function verifypin()
    {
        $wallet=auth()->user()->accounts(); 
        $correct_pin=Hash::check(request()->transaction_pin, $wallet->pluck('transaction_pin')[0]);  
        if (!$correct_pin) {
            $info=[ 
                'message'=>"Invalid Pin",
                'status'=>false, 
                'wallet'=>$wallet
            ];
           return response()->json($info, 401);  
        }
        $data=[ 
            'message'=>"Correct Pin",
            'status'=>true,  
        ];
        return response()->json($data, 200); 

    }

  
}
