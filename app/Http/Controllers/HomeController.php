<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\GalerImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $album = Album::all();
        $query=GalerImage::where('user_id',auth()->id());
        if($request->category){
          $query->where('category',$request->category);
        }

        if($request->sort_by){
          $order=($request->sort_by=='terakhir')?'ASC':'DESC';
          $query->orderBy('created_at',$order);
        }else{
            $query->orderBy('created_at','DESC');
        }

        $data['images']=$query->paginate(2);

        return view('home',$data,['album' => $album]);
    }
}
