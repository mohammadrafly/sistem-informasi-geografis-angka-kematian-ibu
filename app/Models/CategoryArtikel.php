<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryArtikel extends Model
{
    use HasFactory;
    
    protected $table = 'category_artikel';
    protected $guarded = [];
}
