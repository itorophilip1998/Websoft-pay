<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    
    public function store()
    {

            request()->validate([
                'email'=>['required','email'],
             ]);
             $data= News::create(request()->all());
            return response()->json(['message' => 'Successfully created','data'=> $data],200);

    }
}
