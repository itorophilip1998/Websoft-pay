<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

    public function store()
    {
        request()->validate([
            'email'=>['required','email'],
            'name'=>['required'],
            'message'=>['required'],
         ]);
         $data= Contact::create(request()->all());
        return response()->json(['message' => 'Successfully created','data'=> $data],200);
    }

}
