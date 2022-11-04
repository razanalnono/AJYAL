<?php

namespace App\Http\Middleware;

use App\Models\Trainee;
use Closure;
use App\Models\User;
use App\Models\Trainer;
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
    public function handle(Request $request, Closure $next, $user_type ='trainer')
    {
        if ($user_type == 'trainer') {
            if (auth()->user() instanceof Trainer) {
                if (auth()->check()) {
                    return $next($request);
                
                } else {
                    return response()->json([
                        'status' => 403,
                        'message' => 'Trainer can access this page',
                    ]);
                }
            } else {
                if (auth()->user() instanceof Trainee) {
                    return $next($request);
                } else {
                    return response()->json([
                        'status' => 403,
                        'message' => 'Trainee can access this page',
                    ]);
                }
            }
        }
}}