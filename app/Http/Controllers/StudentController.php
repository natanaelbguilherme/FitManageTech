<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    public function store(Request $request)
    {

        try {

            $data = $request->all();

            $request->validate([
                'name' => 'string|required',
                'email' => 'string|required',
                'date_birth' => 'string|required',
                'cpf' => 'string|required|max:14',
                'cep' => 'string',
                'street' => 'string',
                'state' => 'string',
                'netghborhood' => 'string',
                'city' => 'string',
                'number' => 'string',
                'contact' => 'string|required|max:20'

            ]);

            $user_id = $request->user()->id;
            $plan_id = $request->user()->plan_id;

            $planType = Plan::find($plan_id);

            $existStudent = Student::where('email', $data['email'])->orwhere('cpf', $data['cpf'])->count();

            $count = Student::where('user_id', $user_id)->count();

            if ($existStudent !== 0) return $this->error('estudante ja cadastrado', Response::HTTP_CONFLICT);


            if ($planType->limit == 0) {
                $student = Student::create([
                    'user_id' => $user_id,
                    ...$data
                ]);
            }

            if ($count >= $planType->limit) return $this->error('voce atingiu o maximo de estudantes', Response::HTTP_FORBIDDEN);

            $student = Student::create([
                'user_id' => $user_id,
                ...$data
            ]);

            return $student;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
