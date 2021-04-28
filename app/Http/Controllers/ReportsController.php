<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;

class ReportsController extends Controller
{


    public function index()
    {
        $data=Reports::with('user.accounts')-get(); 
        return response()->json(['data'=> $data],200); 
    }

   
    public function store()
    {
        Validator::make([
            'user_id'=>['required'],
            'name'=>['required'],
            'type'=>['required'],
         ]);
         $data= Reports::create(request()->all());
        return response()->json(['message' => 'Successfully created','data'=> $data],200); 
    }

   
    public function destroy(Reports $reports)
    {
        $reports->delete();
        return response()->json(['message' => 'Successfully deleted','data'=> $reports],200);
    }
   
}
