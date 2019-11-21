<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Images;
use Validator,Redirect,Response,File;

class ImagesController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {

        }
        return view('admin/images');
    }

    public function save()
    {
        request()->validate([
            'fileUpload' => 'required|image|mimes:jpeg,png,gif|max:500',
        ]);
        if ($files = request()->file('fileUpload')) {
            $destinantionPath = 'images/';
            $profileImage = date('d m Y His') . "." . $files->getClientOriginalExtension();
            $files->move($destinantionPath, $profileImage);
        }
        return redirect('admin/images')
        ->withSuccess('Images Successfully Uploaded');
    }
}
