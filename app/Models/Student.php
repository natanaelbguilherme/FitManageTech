<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'date_birth',
        'contact',
        'cep',
        'street',
        'state',
        'neighborhood',
        'user_id',
        'city',
        'number'
    ];



    public function workouts()
    {
        return $this->hasmany(Workout::class);
    }
}
