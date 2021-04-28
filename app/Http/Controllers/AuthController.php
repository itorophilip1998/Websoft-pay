<?php

namespace App\Http\Controllers; 
use App\Mail\Verify;
use App\Mail\Reset;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 
        ['signin','signup','verify','resetVerify','passwordReset','resendLink']]);
    } 
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup()
    { 
        Validator::make(request()->all(), [
            'name' => 'required|string|between:5,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:5',
            'role_id' => 'required:integer|max:1',
        ]);
 
        $user=User::create([
            'name'=> request()->name,
            'password' =>Hash::make(request()->password),
            'email'=> request()->email,
            'role_id'=> request()->role_id,
            ]);  
        $user->accounts()->create(['user_id'=>$user->id]);
          return $this->sendCode($user);
    }

    public function signin()
    {
        Validator::make(request()->all(), [ 
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

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
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
        return response()->json(auth()->user());
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
            'access_token' => "bearer ".$token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }
   public function  resendLink(){ 
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
           'content'=>"Welcome to Websoft-pay. Before you can start accepting payments and making transactions, you need to confirm your email address.",
           'code'=>$verification_code
       ];
       try {
          Mail::to(request()->email)->send(new Verify($subject, $email, $data));  
       } catch (\Throwable $th) {
           //throw $th;
       }

        return response()->json([
            'success'=> true,
            'message'=> "We have send a verification to your email address",
            'email'=> $user->email,
         ],200);
        
    }
    public function verify()
    { 
        Validator::make(request()->all(), [ 
            'email' => 'required|string|email' 
        ]);
        // get email and code
        $vCode=request()->verification_code;
        $email=request()->email;
        $user=User::where('email',$email)
        ->where('verify_code',$vCode)->first(); 

        // invalid code or email from user
       if (!$user) {
        return response()->json(['success'=> false, 'message'=> "Verification code or Email is invalid."]); 
       } 
    //    verify user now
       $user->update(['email_verified_at'=>now()]); 
    //    login and send token response
       $token=auth()->login($user);
       return $this->respondWithToken($token); 
    }

    public function resetVerify(){
        Validator::make(request()->all(), [ 
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
        $link="http://localhost:3000/auth/reset-password?$token#$email";
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
        return response()->json(['success'=> false, 'message'=> "A reset link has been sent to your email $email"]);  

    }

    public function passwordReset(){

        Validator::make(request()->all(), [ 
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:5', 
            'token' => 'required|string|min:10',   
        ]);
        
        $check= DB::table('password_resets')->where('email',request()->email)
        ->where('token',request()->token)->first(); 
        $user=User::where('email',$check->email)->update(['password'=>Hash::make(request()->password)]); 
        $check->delete();
        return response()->json(['success'=> true, 'message'=> "Password Updated"]);  
        
    }
}