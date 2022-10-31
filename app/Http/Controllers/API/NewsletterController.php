<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    //

    public function index(){
        $news=Newsletter::paginate();
        return $news;
    }


    public function store(Request $request){
        
        $newsletter=Newsletter::create($request->all());
        return response()->json([
            'code'=>201,
            'message'=>'Sent',
            'content'=>$newsletter
        ]);
    }
}