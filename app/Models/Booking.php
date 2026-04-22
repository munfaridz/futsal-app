<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = ['user_id', 'nama_tim', 'lapangan', 'tanggal', 'jam_mulai', 'durasi', 'total_harga'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
