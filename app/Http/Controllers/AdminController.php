<?php

namespace App\Http\Controllers;

use App\DataImage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $countImage = DataImage::count();
        $countMember= User::count();
        return view('admin/dashboard', ['countImage'=>$countImage, 'countMember'=> $countMember]);
    }
}
