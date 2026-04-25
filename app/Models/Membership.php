<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tim',
        'level',
        'expiry_date',
        'discount_rate',
    ];

    // INI BAGIAN PALING PENTING:
    // Nama fungsi ini harus 'user' supaya nyambung dengan ->relationship('user', 'name')
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}