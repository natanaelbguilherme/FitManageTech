<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Student;
use App\Models\Workout;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    public function store(Request $request)
    {

        try {

            $data = $request->all();

            $existStudent = Student::find($data['student_id']);
            if (!$existStudent) return $this->error('estudante não encontrado', Response::HTTP_NOT_FOUND);


            $existExercise = Workout::where('day', $data['day'])
                ->where('exercise_id', $data['exercise_id'])
                ->where('student_id', $data['student_id'])
                ->count();
            if ($existExercise !== 0) return $this->error('voce ja incluiu esse exercicio para ' . $data['day'], Response::HTTP_CONFLICT);


            $request->validate([
                'student_id' => 'required|int',
                'exercise_id' => 'required|int',
                'repetitions' => 'required|int',
                'weight' => 'required|decimal:0,2',
                'break_time' => 'required|int',
                'day' => 'required|in:SEGUNDA,TERÇA,QUARTA,QUINTA,SEXTA,SÁBADO,DOMINGO',
                'observations' => 'string',
                'time' => 'string|required|max:10'
            ]);

            $workout = Workout::create($data);

            return $workout;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
