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
 
 
    public function destroy(Transactions $transactions)
    {
        $transactions->delete();
        return response()->json(['message' => 'Successfully','data'=> $transactions],200);

    }

    public function destroyAll()
    {
        $transactions=Transactions::where('user_id',auth()->user()->id)->delete();
        return response()->json(['message' => 'Successfully','data'=> $transactions],200);

    }
    public function get(Transactions $transactions)
    { 
        return response()->json(['message' => 'Successfully','data'=> $transactions],200); 
    }
    public function getAll()
    { 
        $transactions=Transactions::where('user_id',auth()->user()->id)->get(); 
        return response()->json(['message' => 'Successfully','data'=> $transactions],200); 
    }
}
