<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show($n)
    {
        $variable = config('view.paths')[0];
        return view('article', ['numero' => $n, 'variable' => $variable]);
    }
}
