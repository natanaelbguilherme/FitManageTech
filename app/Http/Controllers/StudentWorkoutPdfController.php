<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentWorkoutPdfController extends Controller
{
    function query($day, $id)
    {
        return Workout::query()
            ->select('exercise_id', 'repetitions', 'weight', 'time', 'break_time', 'observations')
            ->where('student_id', $id)
            ->where('day', $day)
            ->with(['exercise' => function ($query) {
                $query->select('id', 'description');
            }])
            ->get();
    }

    public function export(Request $request)
    {

        $id = $request->input('student_id');

        $user_id = Auth::user()->id;
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

        $name = $student->student_name;

        $pdf = Pdf::loadView('pdfs.studentWorkout', [
            'name' => $name,
            'segunda' => $segunda,
            'terca' => $terca,
            'quarta' => $quarta,
            'quinta' => $quinta,
            'sexta' => $sexta,
            'sabado' => $sabado,
            'domingo' => $domingo
        ]);

        return $pdf->stream('studentworkout.pdf');
    }
}
