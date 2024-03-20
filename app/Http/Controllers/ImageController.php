<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use App\Models\GalerImage;

class ImageController extends Controller
{
    public function storeImage(Request $request)
    {
        $request->validate([
            'caption'=>'required|max:255',
            'category'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg,bmp'
        ],[
            'category.required'=>'Please select a category'
        ]);

        if($request->hasFile('image')){
            
         $file=$request->file('image');

         $image_name=rand(1000,9999).time().'.'.$file->getClientOriginalExtension();
         $thumbPath=public_path('user_images/thumb');
         $resize_image=Image::make($file->getRealPath());
         $resize_image->resize(300,200,function($c){
           
         })->save($thumbPath.'/'.$image_name);

         $file->move(public_path('user_images'),$image_name);
         

        }

        GalerImage::create([
            'user_id'=>auth()->id(),
            'caption'=>$request->caption,
            'category'=>$request->category,
            'image'=>$image_name
        ]);

        return redirect()->back()->with('success',' Foto Berhasil di Tambahkan.');


        
    }
}