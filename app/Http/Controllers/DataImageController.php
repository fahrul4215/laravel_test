<?php

namespace App\Http\Controllers;

use App\DataImage;
use Illuminate\Http\Request;

class DataImageController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(DataImage::select('*'))
            ->addColumn('action', 'admin/action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin/images');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $imageId = $request->image_id;
        $files = self::uploadImage();

        $image = DataImage::updateOrCreate(
            ['id' => $imageId],
            [
                'title' => $request->title,
                'image' => (empty($files)) ? (empty($request->image_name) ? '' : $request->image_name) : $files,
                'status' => $request->status
            ]
        );

        return response()->json($image);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\DataImage  $dataImage
    * @return \Illuminate\Http\Response
    */
    public function show(DataImage $dataImage)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\DataImage  $dataImage
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $where = array('id' => $id);
        $image = DataImage::where($where)->first();

        return response()->json($image);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\DataImage  $dataImage
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, DataImage $dataImage)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\DataImage  $dataImage
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $image = DataImage::where('id', $id)->delete();

        return response()->json($image);
    }

    // Additional
    private function uploadImage()
    {
        $profileImage = '';
        request()->validate([
            'fileUpload' => 'image|mimes:jpeg,png,gif|max:500',
            ]);

            if ($files = request()->file('fileUpload')) {
                $destinantionPath = 'images/';
                $profileImage = "Image " . date('dMY His') . "." . $files->getClientOriginalExtension();
                $files->move($destinantionPath, $profileImage);
            }

            return $profileImage;
        }
    }
