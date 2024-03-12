<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POI extends Model
{
    use HasFactory;

    protected $table = 'poi';
    protected $guarded = [];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class, 'id_kasus', 'id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryPOI::class, 'id_category', 'id');
    }

    public function penyebab()
    {
        return $this->belongsTo(CategoryPenyebab::class, 'id_category', 'id')
                    ->with('kasus');
    }
}
