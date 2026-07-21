<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class FrontendController extends Controller
{
    public function __invoke(): View
    {
        return view('welcome');
    }
}
