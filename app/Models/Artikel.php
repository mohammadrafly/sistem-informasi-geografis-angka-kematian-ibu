<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(CategoryArtikel::class, 'id_category', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
