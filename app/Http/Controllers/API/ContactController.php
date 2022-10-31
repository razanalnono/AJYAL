<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Models\Admin;
use Illuminate\Support\Facades\Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::paginate();

        return $contacts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', ],
            'phone_number' => ['required', 'string', 'max:255'],
            'message' => ['required', 'max:255'],
        ]);

        $contact = Contact::create($request->all());
        // $content=[
        //     'email'=>$request->email,
        //     'phone_number'=>$request->phone_number,
        //     'message'=>$request->message,
        // ];
        $secretary=Admin::where('email', 'razanomar2014@gmail.com')->first();
        Mail::to($secretary->email)->send(new ContactMail($request->email,$request->message));
        return Response::json($contact, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::destroy($id);

        return [
            'message' => 'Deleted Successfully.',
        ];
    }
}