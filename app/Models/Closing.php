<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Closing extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'gmp_criteria',
        'department',
        'description',
        'status',
    ];

    public function finding()
    {
        return $this->belongsTo(Finding::class);
    }
}
