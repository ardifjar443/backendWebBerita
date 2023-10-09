<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'deskripsi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}