<?php

namespace App\Http\Controllers;

use App\Mail\Reset; 
use App\Models\User;
use App\Mail\Verifyme;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public $baseurl="http://localhost:3000"; 
    public function __construct()
    {
        $this->middleware('auth:api', ['except' =>
        ['signin','signup','reset_verify','passwordReset','resendLink','verified']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup()
    {
        request()->validate([
            'name' => 'required|string|between:5,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:7|max:15',
            'role_id' => 'required:integer|max:1',
        ]); 

        $user=User::create([
            'name'=> request()->name,
            'password' =>Hash::make(request()->password),
            'email'=> request()->email,
            'role_id'=> request()->role_id,
            ]);
            $acc=Str::random(3);
           $user->accounts()->create([
               'user_id'=>$user->id,
               'account_type'=>'individual',
               'wallet_id'=>"W-".Time()
               ]);
          return $this->sendCode($user);
    }

    public function signin()
    {
        request()->validate([
            'email' => 'required|string|email' ,
            'password' => 'required|string'
        ]);
      $user=User::where('email',request()->email)
      ->where('email_verified_at','!=',NULL)->first();
    //   check wheather email is verify
      if (!$user) {
        return response()->json(['message' => 'Email not verify'], 401);
      }

        $credentials = request(['email', 'password']);  
        $token = auth()->attempt($credentials); 
        if (!$token) {
            return response()->json(['message' => 'Invalid Email or Password'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user=User::where('id',auth()->user()->id)->with('accounts')->first();
        return response()->json($user,200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' =>$token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => User::where('id',auth()->user()->id)->with('accounts')->first(),
        ]);
    }
   public function  resendLink(){ 
    request()->validate([
        'email' => 'required|string|email'    
    ]);
     $user=User::where('email',request()->email)->first();  
     return $this->sendCode($user);
     }
    public function sendCode($user)
    { 
        // initialize and update code here
        $verification_code=Str::random(5);
        $user->update(['verify_code'=>$verification_code]);

        // send code to mail here example token to email
       $subject="Verification";
       $email=$user->email;
       $data=[
           'name'=>"Hello $user->name",
           'content'=>"Welcome to Websoft-pay. Before you can start accepting payments and make transactions, you need to verify your account.",
           'code'=>$verification_code,
           'link'=>url("/api/auth/verified/$email/$verification_code"),
       ];
       try {
          Mail::to(request()->email)->send(new Verifyme($subject, $email, $data));
       } catch (\Throwable $th) {
           //throw $th;
       }

        return response()->json([
            'success'=> true,
            'message'=> "We have send a verification to your email address",
            'email'=> $user->email,
         ],200);

    }
  
    
    public function verified($email,$vCode)
    {
        $user=User::where('email',$email)
        ->where('verify_code',$vCode)->first(); 
        // invalid code or email from user 
       if (!$user) {
        return response()->json(['success'=> false, 'message'=> "Verification code or Email is invalid."],401);
       }
    //    verify user now
       $user->update(['email_verified_at'=>now()]); 
       return redirect("$this->baseurl/auth/signin?$email"); 
    }

    public function reset_verify(){
        request()->validate( [
            'email' => 'required|string|email'
        ]);
        $email=request()->email;
        $user=User::where('email',request()->email)->first();
        if(!$user)
        {
        return response()->json(['success'=> false, 'message'=> "Verification code or Email is invalid."]);
        }
         $token=Str::random(10);
        //  save token and mail to reset table
        $check= DB::table('password_resets')->where('email',request()->email);
        if(!$check->first()){
           $data= DB::table('password_resets')->insert([
                'email'=>$email,
                'token'=>$token,
                'created_at'=>now()
             ]);
        }
        else{
           $check->update([
                'email'=>$email,
                'token'=>$token,
                'created_at'=>now()
           ]);
         }

        //   send token and mail to email as a reset link example (url/reset/{token}/{email})
        $link="$this->baseurl/auth/reset-password?$token#$email";
        $subject="Reset Password";
        $data=[
            'name'=>"Hello $user->name",
            'content'=>"You have just requested for a password reset link.",
            'link'=>$link
        ];
        try {
            Mail::to(request()->email)->send(new Reset($subject, $email, $data));
         } catch (\Throwable $th) {
             //throw $th;
         }
        return response()->json(['success'=> true, 'message'=> "A reset link has been sent to your email $email"]);

    }

    public function passwordReset(){

        request()->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:5',
            'token' => 'required|string|min:10',
        ]);

        $check= DB::table('password_resets')->where('email',request()->email)
        ->where('token',request()->token); 
        if(!$check->first())
        {
           return response()->json(['success'=> false, 'message'=> "Invalid Email"],401); 
        }
        $user=User::where('email',$check->first()->email)->update(['password'=>Hash::make(request()->password)]); 
        $check->delete();
        return response()->json(['success'=> true, 'message'=> "Password Updated"],200);

    }
}
