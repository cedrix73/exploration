<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create()
    {
        return view('formulaire');
    }

    public function store(Request $request)
    {
        $input = $request->getMethod();
        $nomuser=$request->input('nom');
        return view('retournomuser', compact('nomuser'));
    }


}
