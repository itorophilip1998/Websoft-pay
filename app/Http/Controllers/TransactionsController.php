<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    } 

  
    public function create()
    {
        Validator::make([
            'user_id'=>['required'],
            'account_id'=>['required'],
            'beneficiary'=>['required'], 
            'beneficiary_name'=>['required'],
            'transaction_type'=>['required'],
            'amount'=>['required'],
            'status_from_user'=>['required'],
            'status_from_transaction'=>['required'],
            'status'=>['required'],
         ]);
         $data= Transaction::create(request()->all());
        return response()->json(['message' => 'Successfully created','data'=> $data],200);

    }
 
 
    public function destroy(Transactions $transactions)
    {
        $transactions->delete();
        return response()->json(['message' => 'Successfully deleted','data'=> $transactions],200);

    }

    public function destroyAll()
    {
        $transactions=Transaction::where('user_id',auth()->user()->id)->delete();
        return response()->json(['message' => 'Successfully deleted','data'=> $transactions],200);

    }
    public function get(Transactions $transactions)
    { 
        return response()->json(['message' => 'Successfully deleted','data'=> $transactions],200); 
    }
    public function getAll()
    { 
        $transactions=Transaction::where('user_id',$user)->get(); 
        return response()->json(['message' => 'Successfully deleted','data'=> $transactions],200); 
    }
}
