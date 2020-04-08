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
        // On stocke le message en BD
        $contact = new \App\Contact;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();
        // On envoie le message de confirmation
        Mail::to('felten.cedric73@gmail.com')->send(new Contact($request->except('_token')));
        //Mail::to('felten.cedric73@gmail.com')->queue(new Contact($request->except('_token')));
        return view('confirm');
    }
}
