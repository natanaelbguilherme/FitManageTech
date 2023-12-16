<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $id = Auth::user()->id;

        $search = $request->input('filter');

        $students = Student::query()
            ->where('user_id', $id)
            ->where('name', 'ilike', "%$search%")
            ->orWhere('cpf', 'ilike', "%$search%")
            ->orWhere('email', 'ilike', "%$search%")
            ->orderBy('name', 'asc')
            ->get();

        return $students;
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
                'contact' => 'string|required|max:5'
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
                    'required',
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
