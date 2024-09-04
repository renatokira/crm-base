<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matrices extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'threshold',
        'bandwidth',
        'unit',
        'description',
    ];
}
