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
    public function getAll()
    { 
        $transactions=Transactions::where('user_id',auth()->user()->id)->latest()->get(); 
        return response()->json(['message' => 'Successfully','data'=> $transactions],200); 
    }
}
