<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_cost',
        'total_cost'
    ];

    protected $append = ['used_times'];

    public function shops()
    {
        return $this->belongsToMany(Shop::class)->withPivot(['unit_cost']);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function getUsedTimesAttribute()
    {
        return $this->offers()->sum('used_times');
    }
}
