<?php

namespace App\Http\Controllers;
use exception;
use Carbon\Carbon;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Mail\Message;
use App\Models\passwordReset;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Request;




class ForgotPasswordController extends Controller
{   

    //
    public function forgotPassword(Request $request){
        try{
          $request->validate([
            'email' => 'required|email',
       ]);

         $email = $request->email;
          // Check User's Email Exists or Not
        $client = Client::where('email', $email)->first();
        if(!$client){
            return response([
                'message'=>'Email doesnt exists',
                'status'=>'failed'
            ], 404);
        
            
           }else{
             $token = Str::random(60);
              $domain = URL::to('/');
              $url = $domain.'/reset-password?token='.$token;

              $data['url'] = $url;
              $data['email'] = $request->email;
              $data['title'] = "password reset";
              $data['body'] = "please click this link to reset your password";

              Mail::send('forgotPasswordMail',['data'=>$data], function($message) use ($data){
                 $message->to($data['email'])->subject($data['title']);
              });

                //$dateTime = Carbon::now()->format('Y-m-d H:i:s');
               

              PasswordReset::updateOrCreate(
                ['email'=> $request->email],
                [
                  'email'=>$request->email,
                  'token'=>$token,
                  'created_at'=>Carbon::now()

                ]
                );
                return response()->json(['success'=>true, 'msg'=>"please check your email"]);
           }
            
        } catch(exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
 }

      //reset password view 
       public function resetPasswordMail(Request $request){

        $resetData = PasswordReset::where('token', $request->token)->get();

        if(!$resetData){
          return ('invalid reset token');
        }else{
          if(isset($request->token) ){
          $client = Client::where('email', $resetData[0]['email'])->get();
          return view('resetPassword', compact('client'));
         }else{
           return('404');
        }
       }
    }
      
      //password reset functionality
       public function resetPassword(Request $request){
        $formatted = Carbon::now()->subMinutes(2)->toDateTimeString();
        PasswordReset::where('created_at', '<=', $formatted)->delete();

        $request->validate([
            'password' => 'required',
        ]);

        $passwordreset = PasswordReset::where('token',  $request->token)->first();

        if(!$passwordreset){
            return response([
                'message'=>'Token is Invalid or Expired',
                'status'=>'failed'
            ], 404);
        }

        $client = Client::where('email', $passwordreset->email)->first();
        $client->password = Hash::make($request->password);
        $client->save();

        // Delete the token after resetting password
        PasswordReset::where('email', $client->email)->delete();
        return "<h1>password reset successfuly</h1>";
    }


    

 }
