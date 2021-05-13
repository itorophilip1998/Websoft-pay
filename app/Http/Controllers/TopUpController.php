<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TopUpController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth:api');
    }
    public function store()
    {  
        $topUp=TopUp::create([ 
        "user_id" => auth()->user()->id,
        "status" => request()->status,
        "transaction_id" => request()->transaction_id,
        "tx_ref" => request()->tx_ref,
        "flw_ref" => request()->flw_ref,
        "currency" => request()->currency,
        "amount" => request()->amount,
        ]);
       return $this->transaction($topUp);
    }
 
    public function transaction($topUp)
    {
        $paid=Transactions::create([ 
             'user_id'=>$topUp->user_id,
             'account_id'=>auth()->user()->accounts()->pluck('id')[0],
             'beneficiary'=>auth()->user()->accounts()->pluck('account_number')[0],
             'beneficiary_name'=>auth()->user()->name,
             'transaction_type'=>'topup',
             'amount'=>$topUp->amount,
             'status_from_user'=>"my top up transaction",
             'status_from_transaction'=>'paid',
             'status'=>$topUp->status,
             'reference_no'=>$topUp->tx_ref,
             'transaction_id'=>$topUp->transaction_id
        ]);
        if ($paid) {
            $wallet=auth()->user()->accounts();
            $balance=$wallet->pluck('account_balance')[0] + $topUp->amount;
            $wallet->update([
                'account_balance'=> $balance,
            ]); 
            $data=[
                'transaction'=>$paid,
                'wallet'=>$wallet,
                'message'=>'Successful',
            ];
            return response()->json($data, 200);

        }
    }
 
}
