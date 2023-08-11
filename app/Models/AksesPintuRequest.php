<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesPintuRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'akses_pintu_id', 'id_rfid', 'pin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function akses()
    {
        return $this->belongsTo(AksesPintu::class);
    }
}
