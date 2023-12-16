<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'repetitions',
        'weight',
        'break_time',
        'day',
        'observations',
        'time',
        'student_id',
        'exercise_id'
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function exercice()
    {
        return $this->hasMany(Exercise::class, 'id', 'exercise_id');
    }
}
