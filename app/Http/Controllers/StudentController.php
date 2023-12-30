<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{

    public function index(Request $request)
    {

        $user_id = Auth::user()->id;

        $search = $request->input('filter');

        if (!$search)  return Student::where('user_id', $user_id)->get();

        $students = Student::query()
            ->where('user_id', $user_id)
            ->where('name', 'ilike', "%$search%")
            ->orwhere('user_id', $user_id)
            ->where('cpf', 'ilike', "%$search%")
            ->orwhere('user_id', $user_id)
            ->Where('email', 'ilike', "%$search%")
            ->orderBy('name', 'asc')
            ->get();

        return $students;
    }

    public function listOneStudent($id)
    {
        $user_id = Auth::user()->id;
        $student_id = Student::find($id);

        if (!$student_id) return $this->error('Dado não encontrado', Response::HTTP_NOT_FOUND);
        if ($student_id->user_id !== $user_id) return $this->error('voce nao tem acesso a este dado', Response::HTTP_FORBIDDEN);

        $student = Student::query()
            ->where('id', $id)
            ->first();

        $listOneStudent = [
            "id" => $student->id,
            "name" => $student->name,
            "email" => $student->email,
            "date_birth" => $student->date_birth,
            "cpf" => $student->cpf,
            "contact" => $student->contact,
            "address" => [
                "cep" => $student->cep ? $student->cep : "",
                "street" => $student->street ? $student->street : "",
                "state" => $student->state ? $student->state : "",
                "neighborhood" => $student->neighborhood ? $student->neighborhood : "",
                "city" => $student->city ? $student->city : "",
                "number" => $student->number ? $student->number : ""
            ]

        ];

        return $listOneStudent;
    }


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

    public function destroy(Request $request, $id)
    {
        $user_id = $request->user()->id;

        $student = Student::find($id);

        if (!$student) return $this->error('Dado não encontrado', Response::HTTP_NOT_FOUND);

        if ($student->user_id !== $user_id) return $this->error('voce nao pode excluir este dado', Response::HTTP_FORBIDDEN);

        $student->delete();

        return $this->response('', Response::HTTP_NO_CONTENT);
    }


    public function update($id, Request $request)
    {
        try {

            $user_id = $request->user()->id;

            $student = Student::find($id);

            if (!$student) return $this->error('dado nao encontrado', Response::HTTP_BAD_REQUEST);

            if ($student->user_id !== $user_id) return $this->error('voce nao pode editar este dado', Response::HTTP_FORBIDDEN);

            $request->validate([
                'cpf' => [
                    'min:11',
                    'max:14',
                    Rule::unique('students')->ignore($student->id),
                ],

                'email' => [
                    Rule::unique('students')->ignore($student->id),
                ],

                'contact' => [
                    'max:20',
                    Rule::unique('students')->ignore($student->id),
                ],
            ]);

            $student->update($request->all());

            return $student;
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
