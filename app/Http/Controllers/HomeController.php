<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Гостевая страница
     *
     * @return Application|Factory|View
     */
    public function home()
    {
        return view('pages.home');
    }
}
