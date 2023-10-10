<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;


class beritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::orderBy('created_at', 'desc')->get();

        // foreach ($beritas as $berita) {
        //     $fotoBlob = $berita->foto;
        //     $fotoBase64 = base64_encode($fotoBlob);
        //     $berita->foto = $fotoBase64;
        // }

        return response()->json($beritas, 200);
    }

    public function show($id)
    {
        return Berita::find($id);


    }

    public function store(Request $request)
    {
        $request->validate([
            'author' => 'required',
            'title' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = time() . '.' . $request->foto->extension();

        $request->foto->move(public_path('images'), $imageName);


        // $user = auth()->user(); // Mendapatkan pengguna yang terotentikasi
        // $author = $user->name; // Mengambil nama pengguna sebagai penulis

        $berita = new Berita([
            'title' => $request->title,
            'author' => $request->author,
            // Menggunakan nama pengguna sebagai penulis
            'deskripsi' => $request->deskripsi,
            'content' => $request->content,
            'foto' => '/images/' . $imageName,

        ]);

        $berita->save();




        return response()->json(201);

    }


    public function update(Request $request, $id)
    {
        $berita = Berita::find($id);
        $berita->update($request->all());
        return $berita;
    }

    public function destroy($id)
    {
        $berita = Berita::find($id);
        $berita->delete();
        return response()->json(['message' => 'Berita deleted']);
    }

}