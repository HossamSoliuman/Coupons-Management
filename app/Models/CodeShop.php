<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeShop extends Model
{
    use HasFactory;
    public $table = 'code_shop';
    protected $fillable = [
        'code_id',
        'shop_id',
        'unit_cost'
    ];
}
