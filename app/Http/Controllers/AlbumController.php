<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\GalerImage;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index(){
        return view('buat-album');
    }

    public function storealbum(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
        ]);
    
        $existingAlbum = Album::where('nama', $request->nama)
                            
                             ->first();
    
        if ($existingAlbum) {
            return redirect()->back()->with('error', 'Album with the same name already exists.');
        }
    
        Album::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
        ]);
    
        return view('welcome')->with('success', 'Foto Berhasil di Tambahkan.');    

        
    }
}
