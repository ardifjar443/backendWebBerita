<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;


class beritaController extends Controller
{
    public function index()
    {
        return Berita::all();
    }

    public function show($id)
    {
        return Berita::find($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'deskripsi' => 'required',
        ]);

        $user = auth()->user(); // Mendapatkan pengguna yang terotentikasi
        $author = $user->name; // Mengambil nama pengguna sebagai penulis

        $berita = new Berita([
            'title' => $request->title,
            'author' => $author,
            // Menggunakan nama pengguna sebagai penulis
            'deskripsi' => $request->deskripsi,
        ]);

        $user->beritas()->save($berita);

        return response()->json($berita, 201);
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