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
    
   public function getGoogleData()
   {
       try {
        return Socialite::driver('google')->redirect();
       } catch (\Throwable $th) {
        //    throw $th;
       }
   }

   public function handleProviderCallback()
   {
    try {
        $user = Socialite::driver('google')->user();
        return $this->google($user);
       } catch (\Throwable $th) {
        //    throw $th;
       }

   }

   public function google($user)
   {
       $oldUser1=User::where('email',$user->email)
       ->where('oauth',true)
       ->first();
       $oldUser2=User::where('email',$user->email)
       ->where('oauth',false)
       ->first();

    if(!$oldUser2)
    {
         $newUser=User::create([
             'name'=>$user->name,
             'email'=>$user->email,
             'email_verified_at'=>now(),
             'remember_token'=>Str::random(10),
             'oauth'=>true,
             'password'=>Hash::make($user->id),
             'role_id'=> 3,
         ]);
          $acc=Str::random(3);
          $newUser->accounts()->create([
              'user_id'=>$user->id,
              'wallet_id'=>"W-".Time(),
              'account_type'=>'individual',
              ]);
    }
    elseif ($oldUser2) {
        $oldUser2->update([
            'name'=>$user->name,
            'email'=>$user->email,
            'oauth'=>true,
            'password'=>Hash::make($user->id),
        ]);
    }
    return $this->respondWithToken($user->email,$user->id);

   }
   public function respondWithToken($email,$password)
   {
       return redirect("http://localhost:3000/callback?e=$email&p=$password");
   }


}
