<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifiedPhone extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'otp',
        'code',
        'is_verified',
        'sent_count',
    ];
}
