<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    } 
    public function index()
    {
         $logs=Logs::where('user_id',auth()->user()->id)->get();
         return response()->json($logs, 200);
    }

}
