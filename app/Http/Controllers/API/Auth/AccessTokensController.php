<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActivationCode;
use App\Models\Admin;
use App\Models\Trainee;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Nette\Utils\Random;

class AccessTokensController extends Controller
{
    //
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            // 'password' => 'required|string|min:6',
            //'agent' => 'string'
        ]);

        $email=$request->email;
        $password=$request->password;
        
        //return obj user 
        if($trainee=Trainee::where('email',$email)->first()){
            Hash::check('password', $trainee->password);
            $token=$trainee->createToken('user'. $trainee->id)->plainTextToken;
            $trainee->token=$token;
            $trainee->save();
            

            return Response::json([
                'status'=>403,
                'message'=>'Password Has been sent to your email',
                'data' => $trainee,
            ]);
            
           }
      elseif ($trainer = Trainer::where('email', $email)->first()) {
            Hash::check('password', $trainer->password);
            $token = $trainer->createToken('trainer' . $trainer->id)->plainTextToken;
            $trainer->token = $token;
            $trainer->save();


            return Response::json([
                'status' => 403,
                'message' => 'Password Has been sent to your email',
                'data' => $trainer,
            ]);
        }elseif($admin = Admin::where('email', $email)->first()) {
            Hash::check('password', $admin->password);
            $token = $admin->createToken('user' . $admin->id)->plainTextToken;
            $admin->token = $token;
            $admin->save();


            return Response::json([
                'status' => 403,
                'message' => 'Password Has been sent to your email',
                'data' => $admin,
            ]);
        }else{
            return Response::json([
                'status' => 404,
                'message' => 'Error Credentials',
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