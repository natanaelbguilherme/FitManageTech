<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->id;

        $plan = $request->user()->plan_id;


        try {

            $registered_students = 0;

            $registered_exercices = 0;

            $current_user_plan = Plan::find($plan);

            $remaining_students = $current_user_plan;


            return [
                'registered_students' => $registered_students,
                'registered_exercices' => $registered_exercices,
                'current_user_plan' =>  "Plano " . $current_user_plan->description,
                'remaining_students' => $remaining_students->limit > 0 ? $remaining_students->limit - $registered_students : "Ilimitado"
            ];
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
