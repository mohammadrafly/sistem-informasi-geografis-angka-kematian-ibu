<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPenyebab extends Model
{
    use HasFactory;

    protected $table = 'category_penyebab';
    protected $guarded = [];

    public function kasus()
    {
        return $this->hasMany(Kasus::class, 'id_category', 'id');
    }
}
