<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Student;
use App\Models\Workout;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller

{
    function query($day, $id)
    {
        return Workout::query()
            ->select('exercise_id', 'repetitions', 'weight', 'break_time', 'observations', 'time')
            ->where('student_id', $id)
            ->where('day', $day)
            ->with(['exercise' => function ($query) {
                $query->select('id', 'description');
            }])
            ->get();
    }

    public function index(Request $request, $id)
    {
        $user_id = $request->user()->id;
        $student_id = Student::find($id);

        if (!$student_id) return $this->error('Dado não encontrado', Response::HTTP_NOT_FOUND);
        if ($student_id->user_id !== $user_id) return $this->error('voce nao tem acesso a este dado', Response::HTTP_FORBIDDEN);

        $student = Student::query()
            ->select('id as student_id', 'name as student_name')
            ->where('id', $id)
            ->first();

        $segunda = $this->query('SEGUNDA', $id);
        $terca = $this->query('TERÇA', $id);
        $quarta = $this->query('QUARTA', $id);
        $quinta = $this->query('QUINTA', $id);
        $sexta = $this->query('SEXTA', $id);
        $sabado = $this->query('SÁBADO', $id);
        $domingo = $this->query('DOMINGO', $id);


        $listStudentWorkout = [
            "student_id" => $student->student_id,
            "student_name" => $student->student_name,
            "workouts" => [
                "SEGUNDA" => $segunda,
                "TERÇA" => $terca,
                "QUARTA" => $quarta,
                "QUINTA" => $quinta,
                "SEXTA" => $sexta,
                "SÁBADO" => $sabado,
                "DOMINGO" => $domingo
            ]

        ];

        return $listStudentWorkout;
    }

    public function store(Request $request)
    {

        try {

            $data = $request->all();

            $user_id = $request->user()->id;

            $student = Student::find($data['student_id']);
            if (!$student) return $this->error('Estudante não encontrado.', Response::HTTP_NOT_FOUND);
            if ($student->user_id !== $user_id) return $this->error('O estudante não foi cadastrado por você.', Response::HTTP_NOT_FOUND);

            $exercise = Exercise::find($data['exercise_id']);
            if (!$exercise) return $this->error('Exercicio não encontrado', Response::HTTP_NOT_FOUND);
            if ($exercise->user_id !== $user_id) return $this->error('O Exercicio não foi cadastrado por você.', Response::HTTP_NOT_FOUND);


            $existExercise = Workout::where('day', $data['day'])
                ->where('exercise_id', $data['exercise_id'])
                ->where('student_id', $data['student_id'])
                ->count();
            if ($existExercise !== 0) return $this->error('Você já incluiu esse exercicio para ' . $data['day'], Response::HTTP_CONFLICT);


            $request->validate([
                'student_id' => 'required|int',
                'exercise_id' => 'required|int',
                'repetitions' => 'required|int',
                'weight' => 'required|decimal:0,2',
                'break_time' => 'required|int',
                'day' => 'required|in:SEGUNDA,TERÇA,QUARTA,QUINTA,SEXTA,SÁBADO,DOMINGO',
                'observations' => 'string',
                'time' => 'integer|required|max:10'
            ]);

            $workout = Workout::create($data);

            return $workout;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
