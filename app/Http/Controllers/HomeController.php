<?php

namespace App\Http\Controllers;

use App\DataImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dataImage = DataImage::all();
        return view((DataImage::count() > 0) ? 'show' : 'welcome', ['dataImage'=>$dataImage]);
    }
}
