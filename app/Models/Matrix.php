<?php

namespace App\Models;

use App\Traits\Models\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matrix extends Model
{
    use HasFactory;
    use HasSearch;

    protected $fillable = [
        'name',
        'threshold',
        'bandwidth',
        'bandwidth_unit',
        'description',
    ];
}
