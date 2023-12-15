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

            $existStudent = Student::where('email', $data['email'])->orwhere('cpf', $data['cpf'])->count();
            if ($existStudent !== 0) return $this->error('estudante ja cadastrado', Response::HTTP_CONFLICT);

            $request->validate([
                'name' => 'string|required',
                'email' => 'string|required|unique:students',
                'date_birth' => 'string|required',
                'cpf' => 'string|required|max:14|unique:students',
                'cep' => 'string',
                'street' => 'string',
                'state' => 'string',
                'netghborhood' => 'string',
                'city' => 'string',
                'number' => 'string',
                'contact' => 'string|required|max:20'

            ]);

            $user_id = $request->user()->id;

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