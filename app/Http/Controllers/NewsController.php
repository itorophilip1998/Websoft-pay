<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    
    public function index()
    {
        $data=News::all(); 
        return response()->json(['data'=> $data],200); 

    }
 
    public function store()
    {
       
            Validator::make([
                'email'=>['required','email'],
             ]);
             $data= News::create(request()->all());
            return response()->json(['message' => 'Successfully created','data'=> $data],200); 
            
    }
 
    public function destroy(News $news)
    {
        $news->delete();
        return response()->json(['message' => 'Successfully deleted','data'=> $news],200);

    }
}
