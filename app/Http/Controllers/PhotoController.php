<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImagesRequest;
use App\Repositories\PhotoRepositoryInterface;
use Illuminate\Http\Request;


class PhotoController extends Controller
{
    public function create()
    {
        return view('photo');
    }

    public function store(ImagesRequest $request, PhotoRepositoryInterface $photoRepository)
    {
        $variable = public_path();
        $photoRepository->save($request->image);

        return view('photo_ok', ['variable' => $variable]);
    }
}
