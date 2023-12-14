<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'date_birth',
        'contact',
        'user_id',
        'city',
        'neighborhood',
        'number',
        'street',
        'state',
        'cep'
    ];

    public function student()
    {
        return $this->hasMany(Student::class, 'id', 'user_id');
    }
}
