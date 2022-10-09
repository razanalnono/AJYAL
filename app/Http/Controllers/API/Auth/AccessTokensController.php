<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActivationCode;
use App\Models\Admin;
use App\Models\Trainee;
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
        
        if($admin=Admin::where('email',$email)->first()){
            $activation_code=Random::generate('5');
            $token=$admin->createToken('admin'. $admin->id)->plainTextToken;
            $admin->activation_code = $activation_code;
            $admin->token=$token;
            $admin->save();
            Mail::to($admin->email)->send(new ActivationCode($activation_code));   
            

            return Response::json([
                'status'=>403,
                'message'=>'verify your code ya admin',
                'data' => $admin,
            ]);
            
        //    }if(auth()->check()) {
        //     if (auth()->user() instanceof Trainee) {
                
        // $request->validate([
        //     'email' => 'required|email',
        //     // 'password' => 'required|string|min:6',
        //     //'agent' => 'string'
        // ]);

        // $email=$request->email;
        // //return obj user 
         }elseif($trainee=Trainee::where('email',$email)->first()){
            $activation_code=Random::generate('5');
            $token=$trainee->createToken('trainee'. $trainee->id)->plainTextToken;
            $trainee->activation_code = $activation_code;
            $trainee->token=$token;
            $trainee->save();
            Mail::to($trainee->email)->send(new ActivationCode($activation_code));   
            

            return Response::json([
                'status'=>403,
                'message'=>'verify your code ya trainee',
                'data' => $trainee,
            ]);
            
           }
 else{
            return Response::json([
                'message'=>'not authenticated',
            ]);
        }
        
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
    // }
    

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

    if($admin=Admin::where('email',$email)->where('activation_code',$acode)->first()){
                $admin->status == 1;
                $new_token = $admin->createToken('verify' . $admin->id)->plainTextToken;
                $admin->token=$new_token;
                $admin->save();
                return Response::json([
                   //     'token' => $new_token->plainTextToken,
                        'admin' => $admin,
                        'meassage'=>'Verified',
                    ]);
        }elseif($trainee=Trainee::where('email',$email)->where('activation_code',$acode)->first()){
                $trainee->status == 1;
                $new_token = $trainee->createToken('verify' . $trainee->id)->plainTextToken;
                $trainee->token=$new_token;
                $trainee->save();
                return Response::json([
                   //     'token' => $new_token->plainTextToken,
                        'trainee' => $trainee,
                        'meassage'=>'Verified',
                    ]);} elseif ($trainer = Admin::where('email', $email)->where('activation_code', $acode)->first()) {
            $trainer->status == 1;
            $new_token = $trainer->createToken('verify' . $trainer->id)->plainTextToken;
            $trainer->token = $new_token;
            $trainer->save();
            return Response::json([
                //     'token' => $new_token->plainTextToken,
                'trainer' => $trainer,
                'meassage' => 'Verified',
            ]);}
         else{
            return Response::json([
                'message' => 'Not verified'
            ]);
        }
}
    
}