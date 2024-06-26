<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'number',
    ];

    public function codes()
    {
        return $this->belongsToMany(Code::class)->withPivot(['unit_cost']);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
