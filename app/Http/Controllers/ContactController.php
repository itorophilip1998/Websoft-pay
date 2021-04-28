<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Contact::all(); 
        return response()->json(['data'=> $data],200); 

    }

   
    public function store()
    {
        Validator::make([
            'email'=>['required','email'],
            'name'=>['required'],
            'message'=>['required'],
         ]);
         $data= Contact::create(request()->all());
        return response()->json(['message' => 'Successfully created','data'=> $data],200); 
    }

   
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json(['message' => 'Successfully deleted','data'=> $contact],200);
    }
}
