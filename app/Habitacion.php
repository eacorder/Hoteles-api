<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Habitacion extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name', 'detail'
    ];
}
