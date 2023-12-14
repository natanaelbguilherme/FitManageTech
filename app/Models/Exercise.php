<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'user_id'
    ];

    public function exercise()
    {
        return $this->hasMany(Exercise::class, 'id', 'user_id');
    }
}
