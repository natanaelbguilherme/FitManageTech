<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{

    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $exercices = Exercise::where('user_id', $user_id)->select('id', 'description')->get();

        return $exercices;
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
}
