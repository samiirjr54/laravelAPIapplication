<?php

namespace App\Http\Controllers;


use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class clientController extends Controller 
{
   public function signup(Request $request ){
        $this->validate($request, [
           'name'=> 'required',
           'email'=> 'required|email',
           'password'=> 'required|min:6'
         ]);

          if(Client::where('email', $request->email)->first()){
          return response()->json([
          'status'=> "duplicate entry",
          'message'=> "email already exist"
          ]
          );
        }
    
        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json(['message'=> 'signup succesful'], 201);
 }

    public function login (Request  $request): JsonResponse
        {
          
            $credentials = $request->validate([
                'email'=> 'required|email',
                'password'=> 'required|min:6'
              ]);
            
           $client = Client::where('email', $credentials['email'])->first();

           //Check password
           if($client && Hash::check($request->password, $client->password)) {

              $token = $client->createToken('auth-token')->plainTextToken;
              return response()->json(['token'=>$token, 'client'=>$client, 'message'=> 'login succesful', ], 201);

            }else{
                return response()->json(['status'=>'failed','message'=> 'invalid credentials'], 401);
            }    
        }


         public function logout(Request $request)
    {
            auth()->user()->tokens()->delete();
            return [
            'message' => 'user logged out'
            ];
    }

    //  public function change_password(Request $request){
    //  $request->validate([
    //      'password' => 'required',
    //  ]);
    //      $loggedclient = auth()->user();
    //      $loggedclient->password = Hash::make($request->password);
    //      $token = $loggedclient->createToken('auth-token')->plainTextToken;
    //      $loggedclient->save();
    //      return response([
    //          'message' => 'Password Changed Successfully',
    //          'status'=>'success',
    //          'token'=> $token,
    //          'loggedClient'=> $loggedclient
    //      ], 200);
    //


    public function sendVerifyMail($email){
        if(auth()->user()){
            $client = Client::where('email', $email)->get();
            if(count($client)>0){
                
            //$token = $request->token;
            //$email = $request->email;
            $random = Str::random(60);
            $domain = URL::to('/');
            $url = $domain.'/'.$random;

                $data['url'] = $url;
                $data['email'] = $email;
                $data['title'] = 'Email verification';
                $data['body'] = 'please click verify your email';


            Mail::send('verifyMail', ['data'=>$data], function($message) use($data){
            $message->to($data['email'])->subject($data['title']);
            
            
            //$client = Client::find($client[0]['id']);
            //$client->remeber_token = $random;
            //$client->save();

            return response()->json(['status'=>'success','message'=> 'mail send successfuly'], 200);

        });           
            }else{
               return response()->json(['status'=>'failed','message'=> 'user not found'], 401);
            }
            }else{
                return response()->json(['status'=>'failed','message'=> 'client not authenticated'], 401);
        }
     }


     public function destroy($id)
        {
        $client = Client::find($id);
        if(!empty($client)){
            $client->delete();
        }else{
            return response()->json('user soft deleted');
        }
     }
     
       
}
