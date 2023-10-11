<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
            'foto1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = null;
        if ($request->hasFile('foto')) {
            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images'), $imageName);
        }
    
        $imageName1 = null;
        if ($request->hasFile('foto1')) {
            $imageName1 = time() . 'foto1.' . $request->foto1->extension();
            $request->foto1->move(public_path('images'), $imageName1);
        }
    
        $imageName2 = null;
        if ($request->hasFile('foto2')) {
            $imageName2 = time() . 'foto2.' . $request->foto2->extension();
            $request->foto2->move(public_path('images'), $imageName2);
        }
    
        $imageName3 = null;
        if ($request->hasFile('foto3')) {
            $imageName3 = time() . 'foto3.' . $request->foto3->extension();
            $request->foto3->move(public_path('images'), $imageName3);
        }

        // $user = auth()->user(); // Mendapatkan pengguna yang terotentikasi
        // $author = $user->name; // Mengambil nama pengguna sebagai penulis

        $berita = new Berita([
            'title' => $request->title,
            'author' => $request->author,
            // Menggunakan nama pengguna sebagai penulis
            'deskripsi' => $request->deskripsi,
            'content' => $request->content,
            'foto' => '/images/' . $imageName,
            'foto1' => '/images/' . $imageName1,
            'foto2' => '/images/' . $imageName2,
            'foto3' => '/images/' . $imageName3,

        ]);


        $berita->save();

        $jsonFile = public_path('data/data.json');

        $jsonData = [];
        if (File::exists($jsonFile)) {
            $jsonData = json_decode(File::get($jsonFile), true);
        }

        $jsonData[] = [
            'id' => Str::uuid()->toString(),
            'title' => $request->title,
            'author' => $request->author,
            // Menggunakan nama pengguna sebagai penulis
            'deskripsi' => $request->deskripsi,
            'content' => $request->content,
            'foto' => '/images/' . $imageName,
            'foto1' => '/images/' . $imageName1,
            'foto2' => '/images/' . $imageName2,
            'foto3' => '/images/' . $imageName3,
            'created_at' => now()->toDateTimeString(),
            // Waktu pembuatan
            'updated_at' => now()->toDateTimeString(),
            // Waktu pembaruan


        ];

        File::put($jsonFile, json_encode($jsonData));

        exec('git add .');
        exec('git commit -m "Pesan commit otomatis"');
        exec('git push origin main');



        return response()->json($berita);

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