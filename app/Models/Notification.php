<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $guarded = [];

    public function scopeUnread($query, $userId)
    {
        return $query->where('user_id', $userId)
                     ->where('read', '0');
    }

    public function scopeUpdateToRead($query, $id)
    {
        return $query->where('id', $id)->update(['read' => '1']);
    }    
}
