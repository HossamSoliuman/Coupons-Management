<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferUsage extends Model
{
    use HasFactory;
    protected $fillable = [
        'offer_id',
        'phone_number'
    ];
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
