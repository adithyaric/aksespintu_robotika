<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesPintu extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_rfid',
        'pin',
        'status',
        'approved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'approved_at' => 'datetime',
    ];
}
