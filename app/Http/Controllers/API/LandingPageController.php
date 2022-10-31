<?php

namespace App\Http\Controllers\API;

use App\Models\News;
use App\Models\Page;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Info;
use App\Models\OurWork;
use App\Models\Program;
use App\Models\Social;

class LandingPageController extends Controller
{
    //

    public function index(){
        return[
           'pages' => Page::select('bio','vision','goals','logo')->get(),
            'news'=> News::with('images')->limit(5)->get(),
            'contact'=>Contact::select('email','phone_number','message'),
            'info'=>Info::select('email','address','mobile','telephone','fax'),
            'programes'=>Program::select('name','description','image','start_ad','end_ad'),
            'social'=>Social::select('name','icon','url'),
            'ourWork'=>OurWork::with('images')->limit(5)->get(),
        ];
    }
}