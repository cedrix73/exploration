<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImagesRequest;
use Illuminate\Http\Request;


class PhotoController extends Controller
{
    public function create()
    {
        return view('photo');
    }

    public function store(ImagesRequest $request)
    {
        $variable = public_path();
        $request->image->store(config('images.path'), 'public');
        return view('photo_ok', ['variable' => $variable]);
    }
}
