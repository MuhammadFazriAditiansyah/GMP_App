<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'gmp_criteria',
        'department',
        'description',
        'week',
        'year',
    ];

    public function closing()
    {
        return $this->hasOne(Closing::class);
    }
}
