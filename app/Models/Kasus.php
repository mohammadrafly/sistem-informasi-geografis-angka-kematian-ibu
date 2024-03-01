<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    use HasFactory;

    protected $table = 'kasus';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(CategoryPenyebab::class, 'id_category', 'id');
    }
}
