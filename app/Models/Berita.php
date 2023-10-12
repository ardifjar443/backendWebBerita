<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'deskripsi', 'content', 'foto','foto1','foto2','foto3','dataArray'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}