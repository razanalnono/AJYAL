<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActivationCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Nette\Utils\Random;

class AccessTokensController extends Controller
{
    //
    public function store(Request $request){

        $request->validate([
            'email' => 'required|email',
            // 'password' => 'required|string|min:6',
            //'agent' => 'string'
        ]);

        $email=$request->email;
        //return obj user 
        if($user=User::where('email',$email)->first()){
            $activation_code=Random::generate('5');
            $token=$user->createToken('user'. $user->id)->plainTextToken;
            $user->activation_code = $activation_code;
            $user->token=$token;
            $user->save();
            Mail::to($user->email)->send(new ActivationCode($activation_code));   
            

            return Response::json([
                'status'=>403,
                'message'=>'verify your code',
                'data' => $user,
            ]);
            
           }else{
            return Response::json([
                'message'=>'not authenticated',
            ]);
        }
        

        // $user=User::where('email',$request->email)->first();
        
        // if($user && Hash::check($request->password,$user->password)){
        //     $agent=$request->userAgent();
        //     //return object of token
        //    $token= $user->createToken($agent);
           
        //    'token'=>$token->plainTextToken,
        //     'return Response::json([
        //     user'=>$user,
        //    ]);
           
        // }
        
        // return Response::json([
        //     'message'=>'Invalid Login Credentials'
        // ]);
    }


// public function verify(Request $request){
    
// $acode=$request->activation_code;
// if($user=User::where('activation_code',$acode)->first()){
// if($user->status==1){
//   $token = $user->createToken('user' . $user->id)->plainTextToken;
//   return Response::json([
//                'token'=>$token->plainTextToken,
//             'user'=>$user,
//            ]);

// }else{
// return Response::json([
//     'message'=>'Not verified'
// ]);
// }

    
// }
    

// }


public function verify(Request $request){
    $email =$request->email;
    $acode = $request->activation_code;

    if($user=User::where('email',$email)->where('activation_code',$acode)->first()){
                $user->status == 1;
                $new_token = $user->createToken('verify' . $user->id)->plainTextToken;
                $user->token=$new_token;
                $user->save();
                return Response::json([
                   //     'token' => $new_token->plainTextToken,
                        'user' => $user,
                        'meassage'=>'Verified',
                    ]);
        } else {
            return Response::json([
                'message' => 'Not verified'
            ]);
        }
}
    
}