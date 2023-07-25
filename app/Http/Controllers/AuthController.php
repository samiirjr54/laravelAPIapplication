<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\models\User;


class AuthController extends Controller{
  
    public function signup(Request $request ){
        $this->validate($request, [
           'name'=> 'required',
           'email'=> 'required|email',
           'password'=> 'required|min:6'
         ]);
            
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);


        return response()->json(['message'=> 'signup succesful'], 201);
 }

    public function login (Request  $request): JsonResponse
        {
            try {
              $credentials = $request->only(['name', 'password']);

              if(Auth::attempt($credentials)){
                
                $user = Auth::user();

                $is_admin = $user->hasRole('user');

                $token = $user->createToken('auth-token')->plainTextToken;

                return response()->json([ 'token'=>$token,'user'=>$user,'message' => 'Login successful', 'is_admin' => $is_admin], 200);

              }

                return response()->json(['message', 'Invalid credentials'], 401);
                

            } catch (ValidationException $e) {
              $errors = $e->validator->errors()->all();
              return response()->json(['errors' => $errors], 422);
            }


}
































    public function logout(Request $request){
       
       //$user = $request->user();

       //$user->tokens()-delete();

       $request->user()->currentAccessToken()->delete();

       return response()-json(['message'=>"logout succesful"]);
       
    }

    public function profile(Request $request){
         $user = Auth::user();
         return response()->json(['message'=> "profile dashboard"], 201);
    }
}