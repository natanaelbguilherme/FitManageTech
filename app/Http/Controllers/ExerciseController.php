<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Student;
use App\Models\Workout;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{

    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $exercises = Exercise::where('user_id', $user_id)->select('id', 'description')->get();

        return $exercises;
    }

    public function store(Request $request)
    {

        try {

            $data = $request->all();

            $request->validate([
                'description' => 'string|required|max:255'
            ]);

            $user_id = $request->user()->id;


            $existExercise = Exercise::where('description', $data['description'])->where('user_id', $user_id)->count();

            if ($existExercise !== 0) return $this->error('este exercicio ja existe', Response::HTTP_CONFLICT);

            $exercise = Exercise::create([
                'user_id' => $user_id,
                ...$data
            ]);

            return $exercise;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Request $request, $id)
    {
        $user_id = $request->user()->id;

        $exercise = Exercise::find($id);

        $count = Workout::query()->where('exercise_id', $id)->count();

        if ($count !== 0) return $this->error('Existem alunos com este exercicio', Response::HTTP_CONFLICT);


        if (!$exercise) return $this->error('Dado não encontrado', Response::HTTP_NOT_FOUND);

        if ($exercise->user_id !== $user_id) return $this->error('voce nao pode excluir este dado', Response::HTTP_FORBIDDEN);

        $exercise->delete();

        return $this->response('', Response::HTTP_NO_CONTENT);
    }
}
