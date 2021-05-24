<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    } 
    public function store()
    {
        request()->validate([
            'user_id'=>['required'],
            'message'=>['required'],
            'type'=>['required'],

         ]);
         $data= Reports::create(request()->all());
        return response()->json(['message' => 'Okay! We will get back to you shortly','data'=> $data],200);
    }

}
