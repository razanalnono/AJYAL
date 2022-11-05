<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Trainee;
use App\Models\Trainer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\ResultType\Success;

class checkUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $user_type = 'trainer')
    {
        if (auth()->check()) {

            if ($user_type == 'trainer') {
                if (auth()->user() instanceof Trainer) {
                    return $next($request);
                } else {
                    return response()->json([
                        'status' => 403,
                        'message' => 'trainer can access only to this page'
                    ]);
                }
            }

            return response()->json([
                'status' => 403,
                'message' => 'you can not access ti this pages'
            ]);
        } else {
            if ($request->headers->get("Authorization")) {
                $token = Str::after($request->headers->get("Authorization"), 'Bearer ');
                $user = Trainer::where('token', $token)->first();
                if (!$user) {
                    $user = Trainee::where('token', $token)->first();
                }
                if ($user) {

                    Auth::setUser($user);
                    if ($user_type == 'trainer') {
                        if (auth()->user() instanceof Trainer) {
                            return $next($request);
                        } else {
                            return response()->json([
                                'status' => 403,
                                'message' => 'trainer can access only to this page'
                            ]);
                        }
                    } else {
                        if (auth()->user() instanceof Trainee) {
                            return $next($request);
                        } else {
                            return response()->json([
                                'status' => 403,
                                'message' => 'trainer can access only to this page'
                            ]);
                        }
                    }
                }
            }
        }
        return $next($request);
    }}