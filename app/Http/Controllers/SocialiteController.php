<?php

namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
   public function redirectToProvider()
   {
       return Socialite::driver()->redirect();
   }
 
   public function handleProviderCallback()
   {
     $user = Socialite::driver()->user(); 
     return $this->google($user);  

   }
 
   public function google($user)
   {

       $oldUser=User::where('email',$user->email)
       ->first(); 
    if(!$oldUser)
    {
         $newUser=User::create([
             'name'=>$user->name,
             'email'=>$user->email,
             'email_verified_at'=>now(),
             'remember_token'=>Str::random(10),
             'password'=>Hash::make($user->id),
             'role_id'=> 3, 
         ]); 
        $newUser->accounts()->create(['user_id'=>$newUser->id]);  
        $token=auth()->login($newUser);
        return $this->respondWithToken($token);
    }
    else { 
        $credentials =  ['email'=>$user->email, 'password'=>$user->id]; 
        $token = auth()->attempt($credentials);
        return $this->respondWithToken($token);

    }
    
   }
   protected function respondWithToken($token)
   {
       return response()->json([
           'access_token' => "bearer ".$token,
           'token_type' => 'bearer',
           'expires_in' => auth()->factory()->getTTL() * 60,
           'user' => auth()->user(),
       ]);
   }

}
