<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;


class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(ContactRequest $request)
    {
        //from(getenv('MAIL_USERNAME'))->
        Mail::to('felten.cedric73@monsite.com')->queue(new Contact($request->except('_token')));
        return view('confirm');
    }
}
