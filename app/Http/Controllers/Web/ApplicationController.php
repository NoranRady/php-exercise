<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ApplicationController extends Controller
{

    public function create()
    {
        return view('applications.create');
    }

    public function historics($symbol)
    {
        return view('applications.historics', [
            'symbol' => $symbol,
        ]);
    }
}