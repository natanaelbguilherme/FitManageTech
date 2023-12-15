<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
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

    public function student()
    {
        return $this->hasMany(Student::class, 'id', 'user_id');
    }
}