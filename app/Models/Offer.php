<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_id',
        'shop_id',
        'name',
        'amount',
        'max_usage_times',
        'used_times',
    ];



    public function code()
    {
        return $this->belongsTo(Code::class);
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
